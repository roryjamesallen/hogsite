import re
import json
import gzip
from urllib.request import Request, urlopen
import requests

products_json = {}
for pagenumber in range(1,10):
    print(pagenumber)
    with open(f'tesco{pagenumber}.html') as f:
        html = f.read()
        regex = '_64Yvfa_verticalTile.*?products\/(.*?)\">(.*?)<.*?src=\"(.*?)\".*?Meal Deal (.*?) Clubcard'
        matches = re.findall(regex,html)
        for index, match in enumerate(matches):
            print(f'Match {index}')
            products_json[match[0]] = {'name': match[1], 'type': match[3], 'image': match[2]}

            img_data = requests.get(match[2]).content
            with open(f'{match[0]}.jpg', 'wb') as handler:
                handler.write(img_data)

print('Writing')
with open('products.json', 'w') as fp:
    fp.write(json.dumps(products_json, indent=True))
