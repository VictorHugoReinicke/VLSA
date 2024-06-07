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

nltk.download('vader_lexicon')

# Define o caminho da pasta
img_folder = 'imgPost/'

# Certifique-se de que a pasta exista. Se não existir, crie-a.
if not os.path.exists(img_folder):
    os.makedirs(img_folder)

with open('session_data.json', 'r') as f:
    serializedData = f.read()

# Deserialize JSON data to Python object
sessionData = json.loads(serializedData)

userId = sessionData["userId"]

conexao = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='vlsa'
)

cursor = conexao.cursor()

comando = f'SELECT EmailInstagram, Senha, Link_postagens, idPostagens FROM postagens WHERE idUsuarios = {userId} ORDER BY idPostagens DESC limit 1'
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
except:
    # Apaga os valores do banco de dados se o login falhar
    delete_command = f'DELETE FROM postagens WHERE idPostagens = {idPostagens}'
    cursor.execute(delete_command)
    conexao.commit()
    print("Falha no login. Os valores correspondentes foram apagados do banco de dados.")
    driver.quit()
    exit()
time.sleep(3)
links = driver.find_elements(By.TAG_NAME, 'a')

link_certo = str(link_postagens)
links_certos = [link for link in links if link.get_attribute('href') == link_certo]

if links_certos:
    links_certos[0].click()
else:
   delete_command = f'DELETE FROM postagens WHERE idPostagens = {idPostagens}'
   cursor.execute(delete_command)
   conexao.commit()
   print("Postagem não encontrada. Os valores correspondentes foram apagados do banco de dados.")
   driver.quit()
   exit()
time.sleep(4)


comments = driver.find_elements(By.CLASS_NAME,'_ap3a')
all_but_last = comments[:-1]  # Get all elements except the last
comments = [comment.text for comment in all_but_last]
print(comments)

# pega a url da imagem da postagem
img_container = driver.find_element(By.CSS_SELECTOR, 'div._aagu._aato')
img_url = img_container.find_element(By.TAG_NAME, 'img').get_attribute('src')

# Escrever a URL da imagem em um arquivo img_url.txt
with open('img_url.txt', 'w') as f:
    f.write(img_url)

df = {'comments': comments}
data = pd.DataFrame(df)

sia = SentimentIntensityAnalyzer()

dicionario_sentimento = {
    "Horrível": {"traducao": "dreadful", "sentimento": -1},
    "Péssimo": {"traducao": "terrible", "sentimento": -1},
    "Ruim": {"traducao": "bad", "sentimento": -1},
    "Bom": {"traducao": "good", "sentimento": 1},
    "Ótimo": {"traducao": "excellent", "sentimento": 1},
    "Maravilhoso": {"traducao": "wonderful", "sentimento": 1},
    "Horroroso": {"traducao": "horrible","sentimento":-1},
}

def identificar_genero_e_introduzir_no_dicionario(palavra):
    d = gender.Detector()
    genero = d.get_gender(palavra)
    tradutor = Translator(from_lang='pt-br', to_lang='en')
    traducao = tradutor.translate(str(palavra))
    
    # Adicione a palavra, a tradução, o gênero e o sentimento ao dicionário
    dicionario_sentimento[palavra] = {"traducao": traducao, "genero": genero, "sentimento": 0}

def aumentar_valor_itens_dicionario():
    for palavra in dicionario_sentimento:
        dicionario_sentimento[palavra]["sentimento"] += 1

def traduzir(comentario):
  tradutor = Translator(from_lang='pt-br', to_lang='en')
  traducao = tradutor.translate(str(comentario))

  # Verifique se a palavra está no dicionário
  if comentario in dicionario_sentimento:
    # Use a tradução e o sentimento do dicionário
    traducao = dicionario_sentimento[comentario]["traducao"]
    sentimento = dicionario_sentimento[comentario]["sentimento"]
  else:
    # Adicione a palavra ao dicionário e obtenha o gênero
    identificar_genero_e_introduzir_no_dicionario(comentario)
    # Use a tradução e o sentimento do dicionário
    traducao = dicionario_sentimento[comentario]["traducao"]
    sentimento = dicionario_sentimento[comentario]["sentimento"]

  return traducao, sentimento

pol = []
for i, row in data.iterrows():
    text = row['comments']
    text_t, sentimento = traduzir(text)
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

df2 = data.copy()
df2['polaridade'] = polaridade 
df2.head() 

timestamp = datetime.datetime.now().strftime("%Y%m%d%H%M%S")

image_save_path = os.path.join(img_folder, f"img_{timestamp}.jpg")
response = requests.get(img_url)
image = Image.open(BytesIO(response.content))
image.save(image_save_path)

cnx = mysql.connector.connect(user='root', password='', host='localhost', database='vlsa')
cursor = cnx.cursor()

add_image = ("UPDATE postagens SET imgPost = %s WHERE idUsuarios = %s AND idPostagens = %s ")

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
                " (comentario, polaridade, idUsuario, idPostagens) "
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


df2.to_csv('analysis_data.csv', index=False)
for row in resultado:
        email_instagram, senha, link_postagens, idPostagens = row

save_to_mysql(df2, userId, idPostagens)