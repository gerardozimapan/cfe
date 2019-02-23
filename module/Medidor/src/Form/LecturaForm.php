<?php

namespace Medidor\Form;

use Medidor\Entity\Lectura;
use Zend\Filter\Digits;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

class LecturaForm extends Form
{
    public function __construct()
    {
        parent::__construct('Medidor - Lectura');
        $this->setAttribute('method', 'post');
        
        $this->addElements();
        $this->addInputFilter();
    }
    
    protected function addElements()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        
        $this->add([
            'name' => 'medidor',
            'type' => 'hidden',
        ]);
        
        $this->add([
            'name' => 'medicion',
            'type' => 'text',
            'options' => [
                'label' => 'Lectura',
            ],
        ]);
        
        $this->add([
            'name' => 'fecha',
            'type' => 'datetime',
            'options' => [
                'label' => 'Fecha de Lectura',
                'format' => 'Y-m-d H:i:s',
            ],
            'attributes' => [
                'id' => 'fecha',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
    
    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
        
        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'medidor',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'medicion',
            'required' => true,
            'filters' => [
                ['name' => Digits::class],
                ['name' => ToInt::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'fecha',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
            ],
        ]);
        
    }
}