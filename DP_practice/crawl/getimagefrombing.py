# import requests as r
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from bs4 import BeautifulSoup
import urllib.request
import time

driver = webdriver.Chrome('C:\\Users\\q\\Desktop\\week3\\settings\\chromedriver')
# driver = webdriver.PhantomJS('C:\\Users\\q\\Desktop\\week3\\settings\\phantomjs-2.1.1-windows\\bin\\phantomjs')
driver.implicitly_wait(3)


def scroll_down():
    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")



input = "고양이"
bing = "https://www.bing.com/images/search?q=" + input + "&form=QBIR"
insta = "https://www.instagram.com/explore/tags/" + input

# your storage
storage = "C:\\Users\\q\\Desktop\\week3\\crawl_inspector\\sample\\"
basic_template = \
'''<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    {}
</body>
{}
</html>
'''
name = 0


driver.get(bing)
# src = driver.find_element_by_xpath('//*[@id="vm_c"]/div[4]/div[1]/ul[1]/li[1]/div/div[1]/a/div/img').get_attribute("src")
src = driver.find_element_by_xpath('//*[@id="mmComponent_images_1"]/ul[1]/li[1]/div/div[1]/a/div/img').get_attribute("src")
print ("source : ", src)


def fetch_page(url):
    driver.get(url)
    time.sleep(3)
    soup = BeautifulSoup(driver.page_source, 'html.parser')
    return soup.prettify('utf-8')

def img_link_from_url(url):
    html = fetch_page(url)
    print ("html : %s" % html)
    srcs = []
    trial = 1
    yellow_card = False
    red_card = False
    for row in range(1, 100):
        for col in range(1,30):
            time.sleep(1)
            print ("%dth trial..." % trial)
            try:
                print("trying %s ..." % ('//*[@id="mmComponent_images_1"]/ul[%d]/li[%d]/div/div[1]/a/div/img' % (row, col)))
                src = driver.find_element_by_xpath('//*[@id="mmComponent_images_1"]/ul[%d]/li[%d]/div/div[1]/a/div/img' % (row, col)).get_attribute("src")
            except NoSuchElementException:
                if (yellow_card):
                    print("[*] ended")
                    red_card = True
                    break
                scroll_down()
                yellow_card = True
                time.sleep(1)
                break
            print ("src : %s" % src)
            img_html_from_link(src)
            srcs.append(src)
            trial += 1
            yellow_card = False
        if (red_card):
            break
    return srcs

def img_html_from_link(src):
    global name
    name += 1
    # full_name = "C:\\Users\\q\\Desktop\\week3\\tutorial\\imgs\\" + str(name) + ".jpg"
    # urllib.request.urlretrieve(url, full_name)
    f = open(storage + 'test%d.html' % name, 'w')
    f.write(basic_template.format('<img src="%s">' % src, ""))
    f.close()

img_link_from_url(bing)
# for link in img_link_from_url(bing):
    # img_html_from_link(link)
