<?php
namespace Medidor\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ReciboForm extends Form
{
    public function __construct()
    {
        parent::__construct('Recibo');
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
            'name' => 'medidor_id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'bimestre',
            'type' => 'text',
            'options' => [
                'label' => 'Bimestre',
            ],
        ]);

        $this->add([
            'name' => 'periodoDesde',
            'type' => 'date',
            'options' => [
                'label'  => 'De',
                'format' => 'Y-m-d',
            ],
        ]);

        $this->add([
            'name' => 'periodoHasta',
            'type' => 'date',
            'options' => [
                'label'  => 'A',
                'format' => 'Y-m-d',
            ],
        ]);

        $this->add([
            'name' => 'lecturaAnterior',
            'type' => 'text',
            'options' => [
                'label' => 'Lectura Anterior',
            ],
        ]);

        $this->add([
            'name' => 'lecturaActual',
            'type' => 'text',
            'options' => [
                'label' => 'Lectura Actual',
            ],
        ]);

        $this->add([
            'name' => 'importe',
            'type' => 'text',
            'options' => [
                'label' => 'Importe'
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

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "medidor" field
        $inputFilter->add([
            'name' => 'medidor',
            'required' => true,
            'filters'  => [
                ['name' => 'ToInt'],
            ],
            'validators' => [
                [
                    'name' => 'GreaterThan',
                    'options' => ['min' => 0],
                ],
            ],
        ]);

        // Add input for "bimestre" field.
        $inputFilter->add([
            'name'     => 'bimestre',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 7,
                    ],
                ],
            ],
        ]);

        // Add input for "periodoDesde" field
        $inputFilter->add([
            'name'     => 'periodoDesde',
            'required' => true,
        ]);

        // Add input for "periodoHasta" field.
        $inputFilter->add([
            'name'     => 'periodoHasta',
            'required' => true,
        ]);

        // Add input for "lecturaAnterior" field.
        $inputFilter->add([
            'name'     => 'lecturaAnterior',
            'required' => true,
            'filters'  => [
                ['name' => 'ToInt'],
            ],
            'validators' => [
                [
                    'name'    => 'GreaterThan',
                    'options' => ['min' => 0],
                ],
            ],
        ]);

        // Add input for "lecturaActual" field.
        $inputFilter->add([
            'name'     => 'lecturaActual',
            'required' => true,
            'filters'  => [
                ['name' => 'ToInt'],
            ],
            'validators' => [
                [
                    'name'    => 'GreaterThan',
                    'options' => ['min' => 0],
                ],
            ],
        ]);

        // Add input filter for "importe" field.
        $inputFilter->add([
            'name'     => 'importe',
            'required' => true,
            'filters'  => [
                ['name' => 'NumberParse'],
            ],
            'validators' => [
                [
                    'name' => 'IsFloat',
                ],
            ],
        ]);
    }
}
