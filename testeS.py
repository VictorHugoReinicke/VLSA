
# Importações de Bibliotecas
import pandas as pd 
import re
import time
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Inicia o Navegador 
options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")

service = Service()

driver = webdriver.Chrome(service=service,options=options)

# Entra no Instagram
url = 'https://www.instagram.com/'

driver.get(url)

time.sleep(4)

# Responde o Login
driver.find_element('xpath', '//*[@id="loginForm"]/div/div[1]/div/label/input').send_keys("victorhugoreinicke012021@gmail.com")
time.sleep(4)

driver.find_element('xpath','//*[@id="loginForm"]/div/div[2]/div/label/input').send_keys("ppo1324$$")
time.sleep(4)

driver.find_element('xpath','//*[@id="loginForm"]/div/div[3]').click()
time.sleep(3)


# Verifica se tem o botão de sincrozinar os contatos
botaos = driver.find_elements(By.TAG_NAME,'button')
for botao in botaos:
    if botao.text == 'Agora não':
        botao.click()
time.sleep(2)

# Entra no Perfil do Usuário
Perfis = driver.find_elements(By.TAG_NAME, 'span')
wait = WebDriverWait(driver, 10)
perfil = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[text()='Perfil']")))
perfil.click()
time.sleep(3)

# Entra no Link da Postagem solicitada pelo Usuário
links = driver.find_elements(By.TAG_NAME, 'a')

link_certo = 'https://www.instagram.com/p/CxtyK70riK_hQc0HRc_il0gBfuqRKhD6wzIq-k0/?next=%2F'
links_certos = [link for link in links if link.get_attribute('href') == link_certo]

if links_certos:
    links_certos[0].click()
time.sleep(4)

"""
Pegaria com as respostas do Comentário Junto 

botaoresponder = driver.find_elements(By.TAG_NAME,'button')
for resp in botaoresponder:
    if resp.text == "Ver respostas (1)" or resp.text == "Ver todas as 2 respostas":
        resp.click()
"""

# Pega os comentários da postagem
comments = driver.find_elements(By.CLASS_NAME,'_ap3a')
tamanho = len(comments) - 1 
comments = [comment.text for comment in comments]
print(comments[0:tamanho])

