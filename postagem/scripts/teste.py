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

nltk.download('vader_lexicon')

# Define o caminho da pasta
img_folder = './imgPost/'

# Certifique-se de que a pasta exista. Se não existir, crie-a.
if not os.path.exists(img_folder):
    os.makedirs(img_folder)


options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")
# options.add_argument("--headless")  # Adiciona o modo headless

service = Service()

driver = webdriver.Chrome(service=service, options=options)
 
print("iniciando")
url = 'https://www.instagram.com/'
driver.get(url)
time.sleep(4)

driver.find_element(By.XPATH, '//*[@id="loginForm"]/div/div[1]/div/label/input').send_keys("vlsappoifc")
time.sleep(4)
driver.find_element(By.XPATH, '//*[@id="loginForm"]/div/div[2]/div/label/input').send_keys("ppo1324$$")
time.sleep(4)
driver.find_element(By.XPATH, '//*[@id="loginForm"]/div/div[3]').click()
time.sleep(3)

botaos = driver.find_elements(By.TAG_NAME, 'button')
for botao in botaos:
    if botao.text == 'Agora não':
        botao.click()
time.sleep(2)

wait = WebDriverWait(driver, 10)
perfil = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[text()='Perfil']")))
perfil.click()

time.sleep(3)
links = driver.find_elements(By.TAG_NAME, 'a')

links_certos = [link for link in links if link.get_attribute('href') == "https://www.instagram.com/p/C6o9iccvQbzp5ds1muUDqJFZgy0kt1ExUUDLZw0/?next=%2F"]

if links_certos:
    links_certos[0].click()
time.sleep(4)

comments = driver.find_elements(By.CLASS_NAME,'_ap3a')
all_but_last = comments[2:-1]  # Get all elements except the last
comments = [comment.text for comment in all_but_last]
print(comments)