<?php
require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');

class TestCase extends WebTestCase 
{
	
    function testResponseMainpage() 
    {
        $this->get('http://localhost:8888/qpt2b/index.php');
        $this->assertResponse(200);
    }
    
    function testClickCategory() 
    {
        $this->get('http://localhost:8888/qpt2b/index.php');
        $this->click('Lebensmittel');
        $this->assertResponse(200);
    }
    
    function testClickTextNextPage() 
    {
        $this->get('http://localhost:8888/qpt2b/index.php');
        $this->click('Lebensmittel');
        $this->assertText('Kategorie - Lebensmittel');
    }
    
    function testResponseProductDetail() 
    {
        $this->get('http://localhost:8888/qpt2b/productDetail.php?aid=9720');
        $this->assertResponse(200);
    }
    
    function testErrorParameterAndGoBackToMainpage() 
    {
        $this->get('http://localhost:8888/qpt2b/productDetail.php?aid=xxx');
        $this->assertText('Derzeit kannst du aus');
    }
    
    function testSearchField() 
    {
        $this->get('http://localhost:8888/qpt2b/');
        $this->setField('searchStr', 'Schokolade');
        $this->clickSubmit('go');
    }
    
    function testProductName() 
    {
        $this->get('http://localhost:8888/qpt2b/productDetail.php?aid=774');
        $this->assertText('Bensdorp Schokolade Flocken');
    }
    
    function testNoLoginWhenLoggedOut() 
    {
        $this->get('http://localhost:8888/qpt2b/productDetail.php?aid=774');
        $this->click('zur Einkaufliste');
        $this->assertText('zum Login');
    } 
    
    function testBrowserBackLinkToMainpage() 
    {
        $this->get('http://localhost:8888/qpt2b/');
        $this->click('Lebensmittel');
        $this->back();
        $this->assertText('Derzeit kannst du aus');  
    }
    
    function testWebsite() {
        $this->assertTrue($this->get('http://localhost:8888/qpt2b/'));
    }

	function testWebsiteTitle() 
	{
	    $this->get('http://localhost:8888/qpt2b/productDetail.php?aid=774');
	    $this->assertTitle('Greenpeace - Marktcheck.at');
	}
	
	function testValuationLink() 
	{
	    $this->get('http://localhost:8888/qpt2b/productDetail.php?aid=774');
	    $this->assertLink('Bewertungen');
	}
	
	function testInputFieldDefaults()
	{
	    $this->get('http://localhost:8888/qpt2b/settingsLogin.php');
	    $this->assertFieldById('nickname', '');
	    $this->assertFieldById('password', '');
	    $this->assertFieldById('loginButton', 'Login');
	}
	
	function testLoginTitle() 
	{
	    $this->get('http://localhost:8888/qpt2b/settingsLogin.php');
	    $this->assertTitle('Greenpeace - Marktcheck.at');
	    $this->assertText('Login');
	}
	
	function testInputFieldDefaultValue() 
	{
	    $this->get('http://localhost:8888/qpt2b/settingsLogin.php');
	    $this->assertFieldById('nickname', '');
	    $this->assertFieldById('password', '');
	    $this->assertFieldById('loginButton', 'Login');
	}
	
	function testActionLoginButtonWithoutValues()
	{
	    $this->get('http://localhost:8888/qpt2b/settingsLogin.php');
	    $this->clickSubmit('Login');
	    $this->assertText('Falscher Username oder Passwort');
	}
	
	function testActionLoginButtonWithWrongValues()
	{
	    $this->get('http://localhost:8888/qpt2b/settingsLogin.php');
	    $this->clickSubmit('Login');
	    $this->assertText('Falscher Username oder Passwort');
	}
	
}


?>