from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from bs4 import BeautifulSoup
import sys, time, json

driver = webdriver.Chrome('C:\\Users\\q\\Desktop\\week3\\settings\\chromedriver')
driver.implicitly_wait(3)

if __name__ == '__main__':
    record_fname = "C:\\Users\\q\\Desktop\\week3\\week3\\CS496_03\\DP_practice\\records1.txt"
    url = ""
    if len(sys.argv) > 1:
        record_fname = sys.argv[1]
        print("Import record {}".format(record_fname))

    if record_fname != "":
        f = open(record_fname, 'r')
        json_str = f.read()
        f.close()
        dic = json.loads(json_str)
        print("dic : ", dic)

        url = dic["url"]
        records = dic["records"]

        driver.get(url)
        time.sleep(1)

        for record in records:
            assert "eventType" in record and "css_path" in record
            type = record["eventType"]
            css = record["css_path"]
            elem = driver.find_element_by_css_selector(css)
            elem.click()
            time.sleep(0.5)
