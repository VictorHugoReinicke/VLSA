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

# Define o caminho da pasta
img_folder = 'imgPost'

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
    database='mydb'
)

cursor = conexao.cursor()

comando = f'SELECT EmailInstagram, Senha, Link_postagens FROM postagens WHERE idUsuarios = {userId} ORDER BY idPostagens DESC limit 1'
cursor.execute(comando)
resultado = cursor.fetchall()

options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")

service = Service()

driver = webdriver.Chrome(service=service, options=options)

url = 'https://www.instagram.com/'
driver.get(url)
time.sleep(4)

for row in resultado:
    email_instagram, senha, link_postagens = row

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

Perfis = driver.find_elements(By.TAG_NAME, 'span')
wait = WebDriverWait(driver, 10)
perfil = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[text()='Perfil']")))
perfil.click()
time.sleep(3)

links = driver.find_elements(By.TAG_NAME, 'a')

link_certo = str(link_postagens)
links_certos = [link for link in links if link.get_attribute('href') == link_certo]

if links_certos:
    links_certos[0].click()
time.sleep(4)

comments = driver.find_elements(By.CLASS_NAME,'_ap3a')
all_but_last = comments[:-1]  # Get all elements except the last
comments = [comment.text for comment in all_but_last]
print(comments)

img_container = driver.find_element(By.CLASS_NAME, '_aagu')
img_url = img_container.find_element(By.TAG_NAME, 'img').get_attribute('src')

df = {'comments': comments}
data = pd.DataFrame(df)

sia = SentimentIntensityAnalyzer()

def traduzir(comments):
    translator = Translator(from_lang='pt', to_lang='en')
    traducao = translator.translate(str(comments))
    return traducao

pol = []
for i, row in data.iterrows():
    text = row['comments']
    text_t = traduzir(text)
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

df2 = data.head().copy()
df2['polaridade'] = polaridade 
df2.head()

image_save_path = os.path.join(img_folder, "imagem_postagem.jpg")

response = requests.get(img_url)
image = Image.open(BytesIO(response.content))
image.save(image_save_path)

df2.to_csv('analysis_data.csv', index=False)

# Salvar a URL da imagem em um arquivo
with open("img_url.txt", "w") as f:
    f.write(img_url)
