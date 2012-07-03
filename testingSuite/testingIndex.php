<?php
require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');

class CorrectResponseTests extends WebTestCase {
    function testResponseCorrectnes() {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertResponse(200);
    }
    function testTitle() {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertTitle('qpt2b');
    }
    function testResponseType() {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertMime(array('text/plain', 'text/html'));
    }
}

class ContentTests extends WebTestCase {
    function testSearchfieldDefaultValue() {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertField('searchStr', '');
    }
    function testSearchfieldButtonIsAvailableAndName() {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertField('searchAction', 'Go');
    }
    function testCategoriesLinksAltText() {
        $this->get('http://localhost/qpt2b/index.php');
        $this->assertLink('Essen');
        $this->assertLink('Getränke');
        $this->assertLink('Kosmetik');
    }
    
}
?>