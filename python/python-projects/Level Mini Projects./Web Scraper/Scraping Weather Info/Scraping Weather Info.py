import requests
from bs4 import BeautifulSoup
import pandas as pd

url = "https://weather.com/en-IN/weather/tenday/l/INKA0344:1:IN"
response = requests.get(url)
soup = BeautifulSoup(response.content, "html.parser")
weather_data = []

# Find the main forecast table by class
tables = soup.find_all("table", {"class": "twc-table"})
for table in tables:
    for i, row in enumerate(table.find_all("tr")[1:]):  # Skip table header
        cells = row.find_all("td")
        if len(cells) >= 6:
            day = cells[0].get_text(strip=True)
            date = cells[1].get_text(strip=True)
            desc = cells[2].get_text(strip=True)
            temp = cells[3].get_text(strip=True)
            precip = cells[4].get_text(strip=True)
            wind = cells[5].get_text(strip=True)
            humidity = cells[6].get_text(strip=True)
            weather_data.append({
                "day": day,
                "date": date,
                "desc": desc,
                "temp": temp,
                "precip": precip,
                "wind": wind,
                "humidity": humidity
            })

df = pd.DataFrame(weather_data)
df.to_csv("weather_forecast.csv", index=False)  # Save to CSV
