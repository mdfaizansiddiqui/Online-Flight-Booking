import xml.etree.ElementTree as xml
from xml.dom import minidom

import random

from datetime import datetime
now = datetime.now()

date_time = now.strftime("%a, %d %b %Y %H:%M:%S %z")
print(date_time)


#timestamp = 1579807322
timestamp = 1575946224
date_time_new = datetime.fromtimestamp(timestamp)
future_date = date_time_new.strftime("%a, %d %b %Y %H:%M:%S %z")
print(date_time_new.strftime("%a, %d %b %Y %H:%M:%S %z"))

files = ["indigo.rss","jet_airways.rss","air_india.rss"]

titles = [" closing down"," fires employees"," faces shutdown"," gives a discount"," is closed"]

links = [
"https://www.thehindu.com/news/cities/Delhi/activists-cry-foul-as-govt-notifies-rti-rules/article29805155.ece",
"https://www.thehindu.com/news/cities/Delhi/activists-cry-foul-as-govt-notifies-rti-rules/article29805155.ece",
"https://www.thehindu.com/news/cities/Delhi/activists-cry-foul-as-govt-notifies-rti-rules/article29805155.ece",
"https://www.thehindu.com/news/cities/Delhi/activists-cry-foul-as-govt-notifies-rti-rules/article29805155.ece",
"https://www.thehindu.com/news/cities/Delhi/activists-cry-foul-as-govt-notifies-rti-rules/article29805155.ece"
]

for i in files:
	tree = xml.parse(i)
	root = tree.getroot()
	print(root)
	channel = root.find('channel')
	print(root.find('channel'))
	item = xml.SubElement(channel, 'item')
	title = xml.SubElement(item, 'title')
	link = xml.SubElement(item, 'link')
	pubDate = xml.SubElement(item, 'pubDate')
	title.text = i.split('.')[0] + titles[random.randrange(0,4)]
	link.text = links[random.randrange(0,4)]
	pubDate.text = future_date
	tree.write(i)


'''

timestamp = 1573807322
date_time = datetime.fromtimestamp(timestamp)
print(date_time.strftime("%a, %d %b %Y %H:%M:%S %z"))

<data>
    <items>
        <item name="item1">item1abc</item>
        <item name="item2">item2abc</item>
    </items>
</data>



import xml.etree.ElementTree as ET

# create the file structure
data = ET.Element('data')
items = ET.SubElement(data, 'items')
item1 = ET.SubElement(items, 'item')
item2 = ET.SubElement(items, 'item')
item1.set('name','item1')
item2.set('name','item2')
item1.text = 'item1abc'
item2.text = 'item2abc'

# create a new XML file with the results
mydata = ET.tostring(data)
myfile = open("items2.xml", "wb")
myfile.write(mydata)
'''