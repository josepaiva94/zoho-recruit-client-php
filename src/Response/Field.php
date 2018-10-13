<?php

namespace Apora\ZohoRecruitClient\Response;

/**
 * Response to API method getFields() consists of an array of Field
 *
 * @package Apora\ZohoRecruitClient\Response
 */
class Field
{
    /** @var string */
    protected $section;
    /** @var string */
    protected $label;
    /** @var string */
    protected $type;
    /** @var bool */
    protected $required;
    /** @var bool */
    protected $readOnly;
    /** @var int */
    protected $maxLength;
    /** @var array */
    protected $options;
    /** @var bool */
    protected $customField;

    public function __construct($section, $label, $type, $required, $readOnly, $maxLength, array $options, $customField)
    {
        $this->section = $section;
        $this->label = $label;
        $this->type = $type;
        $this->required = $required;
        $this->readOnly = $readOnly;
        $this->maxLength = $maxLength;
        $this->options = $options;
        $this->customField = $customField;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return bool
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return bool
     */
    public function isCustomField()
    {
        return $this->customField;
    }
}