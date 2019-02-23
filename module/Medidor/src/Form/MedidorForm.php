<?php

namespace Medidor\Form;

use Medidor\Entity\Medidor;
use Zend\Filter\Digits;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

class MedidorForm extends Form
{
    public function __construct()
    {
        parent::__construct('Medidor');
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
            'name' => 'numeroServicio',
            'type' => 'text',
            'options' => [
                'label' => 'Número de Servicio',
            ],
        ]);
        
        $this->add([
            'name' => 'titular',
            'type' => 'text',
            'options' => [
                'label' => 'Titular',
            ],
        ]);
        
        $this->add([
            'name' => 'tarifa',
            'type' => 'text',
            'options' => [
                'label' => 'Tarifa',
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
            'name' => 'numeroServicio',
            'required' => true,
            'filters' => [
                ['name' => Digits::class],
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'titular',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 128,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'tarifa',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
    }
}