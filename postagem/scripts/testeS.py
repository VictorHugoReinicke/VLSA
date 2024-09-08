import pandas as pd 
import re
import time
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import json
import mysql.connector
from nltk.sentiment import SentimentIntensityAnalyzer
from translate import Translator
import requests
from PIL import Image
from io import BytesIO
import os
import nltk
import datetime
import gender_guesser.detector as gender
import os

with open('session_data.json', 'r') as f:
    serializedData = f.read()

# Deserialize JSON data to Python object
sessionData = json.loads(serializedData)

userId = sessionData["userId"]
sessionData['flag'] = "iniciando"
with open('session_data.json', 'w') as f:
    json.dump(sessionData, f)

nltk.download('vader_lexicon')

# Define o caminho da pasta
img_folder = './imgPost/'

# Certifique-se de que a pasta exista. Se não existir, crie-a.
if not os.path.exists(img_folder):
    os.makedirs(img_folder)


    
    
conexao = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='vlsa'
)

cursor = conexao.cursor()

comando = f'SELECT emailInstagram, senha, link_postagem, idPostagem FROM postagens WHERE idUsuario = {userId} ORDER BY idPostagem DESC limit 1'
cursor.execute(comando)
resultado = cursor.fetchall()

options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")
# options.add_argument("--headless")  # Adiciona o modo headless

service = Service()

driver = webdriver.Chrome(service=service, options=options)
 

 
print("iniciando")
url = 'https://www.instagram.com/'
driver.get(url)
time.sleep(4)
for row in resultado:
    email_instagram, senha, link_postagens, idPostagens = row

driver.find_element(By.XPATH, '//*[@id="loginForm"]/div/div[1]/div/label/input').send_keys(email_instagram)
time.sleep(4)
driver.find_element(By.XPATH, '//*[@id="loginForm"]/div/div[2]/div/label/input').send_keys(senha)
time.sleep(4)
driver.find_element(By.XPATH, '//*[@id="loginForm"]/div/div[3]').click()
time.sleep(3)



botaos = driver.find_elements(By.TAG_NAME, 'button')
for botao in botaos:
    if botao.text == 'Agora não':
        botao.click()
time.sleep(2)

try:
    wait = WebDriverWait(driver, 10)
    perfil = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[text()='Perfil']")))
    perfil.click()
    
    sessionData['flag'] = "Acessando o perfil"
    with open('session_data.json', 'w') as f:
        json.dump(sessionData, f)
    
except:
    # Apaga os valores do banco de dados se o login falhar
    delete_command = f'DELETE FROM postagens WHERE idPostagem = {idPostagens}'
    cursor.execute(delete_command)
    conexao.commit()
    print("Falha no login. Os valores correspondentes foram apagados do banco de dados.")
    
    sessionData['flag'] = "Erro ao acessar perfil"
    with open('session_data.json', 'w') as f:
        json.dump(sessionData, f)
    
    driver.quit()
    exit()
time.sleep(3)
links = driver.find_elements(By.TAG_NAME, 'a')

link_certo = str(link_postagens)
links_certos = [link for link in links if link.get_attribute('href') == link_certo]

if links_certos:
    links_certos[0].click()
    sessionData['flag'] = "Postagem encontrada"
    with open('session_data.json', 'w') as f:
        json.dump(sessionData, f)
else:
   delete_command = f'DELETE FROM postagens WHERE idPostagem = {idPostagens}'
   cursor.execute(delete_command)
   conexao.commit()
   print("Postagem não encontrada. Os valores correspondentes foram apagados do banco de dados.")
   sessionData['flag'] = "Postagem não encontrada"
   with open('session_data.json', 'w') as f:
        json.dump(sessionData, f)
   
   driver.quit()
   exit()
time.sleep(4)

# Extrair os comentários como texto
comments = driver.find_elements(By.CLASS_NAME, '_a9zm')  # Lista de elementos contêineres dos comentários
comments_text = []  # Lista para armazenar os textos dos comentários

for x in comments:
    comment = x.find_element(By.CLASS_NAME, '_a9zs')  # Busca o comentário dentro de cada contêiner
    comments_text.append(comment.text)  # Armazena o texto do comentário na lista
    print(comment.text)  # Exibe o comentário

# Pegar a URL da imagem da postagem
img_container = driver.find_element(By.CSS_SELECTOR, 'div._aagu._aato')
img_url = img_container.find_element(By.TAG_NAME, 'img').get_attribute('src')

# Escrever a URL da imagem em um arquivo img_url.txt
with open('img_url.txt', 'w') as f:
    f.write(img_url)

# Criar um DataFrame usando a lista de textos de comentários
df = pd.DataFrame({'comments': comments_text})
print(df)

sia = SentimentIntensityAnalyzer()

def traduzir(comentario):
  tradutor = Translator(from_lang='pt-br', to_lang='en')
  traducao = tradutor.translate(str(comentario))

  return traducao

pol = []
for i, row in df.iterrows():
    text = row['comments']
    text_t= traduzir(text)
    time.sleep(2)
    pol.append(sia.polarity_scores(text_t))
    print(text_t)

polaridade = []
for i in pol:
    if i['compound'] >= 0.25:
        polaridade.append('positivo')
    elif -0.25 < i['compound'] < 0.25:
        polaridade.append('neutro')
    else:
        polaridade.append('negativo')

df2 = df.copy()
df2['polaridade'] = polaridade 
df2.head() 

timestamp = datetime.datetime.now().strftime("%Y%m%d%H%M%S")

image_save_path = os.path.join(img_folder, f"img_{timestamp}.jpg")
response = requests.get(img_url)
image = Image.open(BytesIO(response.content))
image.save(image_save_path)

cnx = mysql.connector.connect(user='root', password='', host='localhost', database='vlsa')
cursor = cnx.cursor()

add_image = ("UPDATE postagens SET imgPost = %s WHERE idUsuario = %s AND idPostagem = %s ")

cursor.execute(add_image, (image_save_path, userId, idPostagens))

cnx.commit()

cursor.close()
cnx.close()
    
def save_to_mysql(df, userid, idPostagens):
    # Estabelece a conexão com o banco de dados
    cnx = mysql.connector.connect(user='root', password='', host='localhost', database='vlsa')

    # Cria um cursor
    cursor = cnx.cursor()

    # Define a query para inserir os dados
    add_data = ("INSERT INTO comentarios "
                " (comentario, polaridade, idUsuario, idPostagem) "
                " VALUES (%s, %s, %s, %s)")

    # Insere cada linha de dados na tabela
    for _, row in df.iterrows():
        data_to_insert = (row['comments'], row['polaridade'], userid, idPostagens)
        cursor.execute(add_data, data_to_insert)

    # Faz o commit das alterações
    cnx.commit()

    # Fecha o cursor e a conexão
    cursor.close()
    cnx.close()

script_dir = os.path.dirname(os.path.realpath(__file__))
csv_path = os.path.join(script_dir, 'analysis_data.csv')

df2.to_csv('analysis_data.csv', index=False)
for row in resultado:
        email_instagram, senha, link_postagens, idPostagens = row

sessionData['flag'] = "success"
with open('session_data.json', 'w') as f:
 json.dump(sessionData, f)

time.sleep(10)
 
sessionData['flag'] = "iniciando"
with open('session_data.json', 'w') as f:
 json.dump(sessionData, f)

save_to_mysql(df2, userId, idPostagens)