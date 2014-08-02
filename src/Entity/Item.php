<?php
namespace Todo\Entity;

class Item
{
    protected $id;
    protected $title;
    protected $status;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @todo Create an abstract and put this method there
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'status' => $this->getStatus(),
            'title' => $this->getTitle(),
        );
    }

    public function fromArray($array)
    {
        foreach ($array as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}