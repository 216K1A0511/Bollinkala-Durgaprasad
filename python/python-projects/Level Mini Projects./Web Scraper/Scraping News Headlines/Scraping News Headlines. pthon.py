import requests
from bs4 import BeautifulSoup

def fetch_article_titles(url):
    response = requests.get(url)
    soup = BeautifulSoup(response.text, "html.parser")
    titles = []
    for heading in soup.select("h3"):  # Many news sites use <h3> tags for headlines
        titles.append(heading.get_text(strip=True))
    return titles

url = "https://www.bbc.com/news"
titles = fetch_article_titles(url)

for i, title in enumerate(titles, 1):
    print(f"{i}. {title}")
