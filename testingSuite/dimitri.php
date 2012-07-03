<?php
require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');

class CorrectResponseTests extends WebTestCase {
  function testResponse() {
    $this->get('http://localhost/marktcheck/index.php');
    $this->assertResponse(200);
  }
  
  function testHeadline() {
    $this->get('http://localhost/marktcheck/productList.php?cid=85');
    $text = 'Active Fruits Multivitaminnektar light, 1 Liter';
    $this->clickLinkById($text);
    $this->assertText($text);
  }
  
  function testNoAmountFood() {
  	$this->get('http://localhost/marktcheck/categoryList.php?type=1');
    $this->assertNoText('(0)');
  }
  
  function testNoAmountDrinks() {
  	$this->get('http://localhost/marktcheck/categoryList.php?type=2');
    $this->assertNoText('(0)');
  }
  
  function testNoAmountCosmetics() {
  	$this->get('http://localhost/marktcheck/categoryList.php?type=3');
    $this->assertNoText('(0)');
  }
  
  function testShoppingLink() {
    $this->get('http://localhost/marktcheck/productDetail.php?aid=9720');
    $id = 'addProduct';
  	$this->assertLinkById($id);
  }
  
  function testTitleAboutMarktcheck() {
    $this->get('http://localhost/marktcheck/settingsAboutMarktcheck.php');
    $text = 'About Marktcheck';
    $id = 'link_back';
    $this->assertText($text);
    $this->assertLinkById($id);
  }
  
  function testTitleAboutGreenpeace() {
    $this->get('http://localhost/marktcheck/settingsAboutGreenpeace.php');
    $text = 'About Greenpeace';
    $id = 'link_back';
    $this->assertText($text);
    $this->assertLinkById($id);
  }
  
  function testTitleSignup() {
    $this->get('http://localhost/marktcheck/settingsSignup.php');
    $text = 'Signup';
    $id = 'link_back';
    $this->assertText($text);
    $this->assertLinkById($id);
  }
  
  function testTitleLogin() {
    $this->get('http://localhost/marktcheck/settingsLogin.php');
    $text = 'Login';
    $id = 'link_back';
    $this->assertText($text);
    $this->assertLinkById($id);
  }
  
  function testTitlePrivacy() {
    $this->get('http://localhost/marktcheck/settingsPrivacy.php');
    $text = 'Privacy';
    $id = 'link_back';
    $this->assertText($text);
    $this->assertLinkById($id);
  }
  
  function testTitleContact() {
    $this->get('http://localhost/marktcheck/settingsContact.php');
    $text = 'Contact';
    $id = 'link_back';
    $this->assertText($text);
    $this->assertLinkById($id);
  }
}