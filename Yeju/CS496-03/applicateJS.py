from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
import time

driver = webdriver.Chrome('C:\\Users\\q\\Downloads\\chromedriver')
driver.implicitly_wait(3)

driver.get('http://115.68.231.165/~db367/mall/')
