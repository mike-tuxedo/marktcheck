<?php
require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');

/* index.php */
class CorrectResponseTests extends WebTestCase 
{
    function testResponseCorrectnes() 
    {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertResponse(200);
    }
    function testTitle() 
    {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertTitle('Greenpeace - Marktcheck.at');
    }
    function testResponseType() 
    {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertMime(array('text/plain', 'text/html'));
    }

    function testSearchfieldDefaultValue() 
    {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertField('searchStr', '');
    }
    function testSearchfieldButtonIsAvailableAndName() 
    {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertFieldById('submit', 'go');
    }
    function testCategoriesLinksAltText() 
    {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertLink('essen');
        $this->assertLink('getränke');
        $this->assertLink('kosmetik');
    }

/* settingsSignup.php */

    function testSiteTitle() 
    {
        $this->get('http://localhost/qpt2b/settingsSignup.php');
        $this->assertTitle('Greenpeace - Marktcheck.at');
        $this->assertText('Registrieren');
    }
}

class SimpleFormTests extends WebTestCase 
{
    /* settingsSignup.php */
    function testInputFieldDefaultValues()
    {
        $this->get('http://localhost/qpt2b/settingsSignup.php');
        $this->assertFieldById('nickname', '');
        $this->assertFieldById('password', '');
        $this->assertFieldById('signupButton', 'Anmelden');
    }
    function testActionSignupButtonWithoutValues()
    {
        $this->get('http://localhost/qpt2b/settingsSignup.php');
        $this->clickSubmit('Anmelden');
        $this->assertText('Die Angaben enthalten nicht erlaubte Zeichen');
    }
    function testActionSignupButtonWithWrongNickname()
    {
        $this->get('http://localhost/qpt2b/settingsSignup.php');
        $this->setFieldById('nickname', 'An nonacceptable nickname');
        $this->setFieldById('email', 'An nacceptable email');
        $this->setFieldById('password', 'An acceptable password');
        $this->clickSubmit('Anmelden');
        $this->assertText('Die Angaben enthalten nicht erlaubte Zeichen');
    }
    function testActionSignupButtonWithWrongEmail()
    {
        $this->get('http://localhost/qpt2b/settingsSignup.php');
        $this->setField('nickname', 'An acceptable nickname');
        $this->setField('email', 'An nonacceptable email');
        $this->setField('password', 'An acceptable password');
        $this->clickSubmit('Anmelden');
        $this->assertText('Die Angaben enthalten nicht erlaubte Zeichen');
    }
    function testActionSignupButtonWithRightValues()
    {
        $this->get('http://localhost/qpt2b/settingsSignup.php');
        $this->setFieldById('nickname', 'AnAcceptableNickname2');
        $this->setFieldById('email', 'An.acceptable2@email.com');
        $this->setFieldById('password', 'AnAcceptablePassword2');
        $this->click('Anmelden');
        $this->assertText('Derzeit kannst du');
    }

    /* Login */
    
    function testActionLoginWithPreviewsValues()
    {
        $this->get('http://localhost/qpt2b/settingsSignup.php');
        $this->setFieldById('nickname', 'mike');
        $this->setFieldById('password', '321');
        $this->click('Login');
        $this->assertText('Derzeit kannst du aus');
    }
    
}
?>