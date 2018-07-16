from selenium import webdriver
import urllib.request
import requests
from bs4 import BeautifulSoup
import random
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import io
import os
from google.cloud import vision
from google.cloud.vision import types


driver = webdriver.Chrome('C:\\Users\\q\\Downloads\\chromedriver')

driver.implicitly_wait(3)

bing = "https://www.bing.com/images/search?q=%EA%B3%A0%EC%96%91%EC%9D%B4&FORM=HDRSC2"
driver.get(bing)
src = driver.find_element_by_xpath('//*[@id="mmComponent_images_1"]/ul[1]/li[1]/div/div[1]/a/div/img').get_attribute("src")
print("source:", src)
#title = WebDriverWait(driver, 10) \
#    .until(EC.visibility_of_element_located((By.XPATH, '''//*[@id="mmComponent_images_1"]/ul[1]/li[5]''')))

#html = urlopen(bing)
#soup = BeautifulSoup(html, 'html.parser')

def fetch_page(url):
    driver.get(url)
    html = driver.page_source
    soup = BeautifulSoup(html, 'html.parser')
    return soup.prettify('utf-8')

def img_link_from_url(url):
#    html = fetch_page(url)
    driver.get(url)
    driver.find_element_by_xpath('//*[@id="mmComponent_images_1"]/ul[1]/li[5]').click()
    title = WebDriverWait(driver, 10) \
        .until(EC.visibility_of_element_located((By.XPATH, '''//*[@id="mmComponent_images_1"]/ul[1]/li[5]''')))
    print(title.text)
    return title

def img_from_link(url):
    name = random.randomrange(1, 1001)
    full_name = "img/" + str(name) + ".jpg"
    urllib.request.urlretrieve(url, full_name)


#link = img_link_from_url(bing)
#img_from_link(link)
#print(link)

print("hi")

'''
driver = webdriver.Chrome('C:\\Users\\q\\Downloads\\chromedriver')

driver.implicitly_wait(1)

driver.get('https://www.bing.com/images/search?q=%EA%B3%A0%EC%96%91%EC%9D%B4&FORM=HDRSC2')

#driver.implicitly_wait(2)
'''
driver.find_element_by_xpath('//*[@id="mmComponent_images_1"]/ul[1]').click()
#//*[@id="mmComponent_images_1"]/ul[1]/li[4]/div/div[1]/a/div/img
#//*[@id="mmComponent_images_1"]/ul[1]/li[4]/div/div[1]/a/div/img
