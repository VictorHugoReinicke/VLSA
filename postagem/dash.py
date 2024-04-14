import streamlit as st
import requests
from PIL import Image
from io import BytesIO
import pandas as pd
import plotly.graph_objects as go

# Ler a URL da imagem do arquivo
with open("img_url.txt", "r") as f:
    img_url = f.read().strip()

# Função para baixar a imagem da URL
def carregar_imagem(url):
    response = requests.get(url)
    image = Image.open(BytesIO(response.content))
    return image

# Carregar imagem da postagem
imagem_postagem = carregar_imagem(img_url)

# Redimensionar a imagem
imagem_postagem.thumbnail((550, 550))

# Carregar os dados de análise
df = pd.read_csv('analysis_data.csv')

# Contagem de ocorrências de cada polaridade
polaridade_counts = df['polaridade'].value_counts()

# Normalização dos valores para representar porcentagens
polaridade_percentages = (polaridade_counts / polaridade_counts.sum()) * 100

# Configuração da página
st.set_page_config(page_title='Análise de Sentimentos', page_icon=':bar_chart:', layout="wide")

# Título
st.title(":bar_chart: Análise de Sentimentos")

# Coluna para a imagem e gráficos
col_imagem, col_graficos = st.columns([3, 3])

# Ajustando o tamanho da barra lateral
col_imagem.markdown("<style>div.Widget.row-widget.stRadio>div{flex-direction:column;width:80%}</style>", unsafe_allow_html=True)

# Exibir a imagem da postagem com uma borda
col_imagem.image(imagem_postagem, caption='Imagem da Postagem')

# Gráfico de Barras Convencional
col_graficos.subheader("Gráfico de Barras ")
fig_barras_convencional = go.Figure(go.Bar(
    x=polaridade_percentages.index,
    y=polaridade_percentages.values,
    marker_color=['blue', 'green', 'red'],
))

fig_barras_convencional.update_layout(
    title='Distribuição da Polaridade dos Comentários',
    xaxis=dict(title='Polaridade'),
    yaxis=dict(title='Porcentagem', range=[0, 100]),
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos.plotly_chart(fig_barras_convencional)

# Gráfico de Pizza
col_graficos.subheader("Gráfico de Pizza")
fig_pizza = go.Figure(data=[go.Pie(labels=polaridade_counts.index, values=polaridade_counts.values, hole=.3)])

fig_pizza.update_traces(marker=dict(colors=['blue', 'green', 'red']))

fig_pizza.update_layout(
    title='Distribuição da Polaridade dos Comentários',
    width=500,
    height=500,
    margin=dict(l=20, r=20, t=40, b=20)  # Ajuste de margens
)

col_graficos.plotly_chart(fig_pizza)
