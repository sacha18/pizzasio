<?php

class Client
{
    private $_num_client;
    private $_nom_client;
    private $_prenom_client;
    private $_email_client;
    private $_adresse_client;
    private $_cp_client;
    private $_ville_client;
    private $_tel_client;
    private $_num_role;

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    /**
     * Get the value of _num_client
     */ 
    public function getNum_client()
    {
        return $this->_num_client;
    }

    /**
     * Set the value of _num_client
     *
     * @return  self
     */ 
    public function setNum_client($_num_client)
    {
        $this->_num_client = $_num_client;

        return $this;
    }

    /**
     * Get the value of _nom_client
     */ 
    public function getNom_client()
    {
        return $this->_nom_client;
    }

    /**
     * Set the value of _nom_client
     *
     * @return  self
     */ 
    public function setNom_client($_nom_client)
    {
        $this->_nom_client = $_nom_client;

        return $this;
    }

    /**
     * Get the value of _prenom_client
     */ 
    public function getPrenom_client()
    {
        return $this->_prenom_client;
    }

    /**
     * Set the value of _prenom_client
     *
     * @return  self
     */ 
    public function setPrenom_client($_prenom_client)
    {
        $this->_prenom_client = $_prenom_client;

        return $this;
    }

    /**
     * Get the value of _email_client
     */ 
    public function getEmail_client()
    {
        return $this->_email_client;
    }

    /**
     * Set the value of _email_client
     *
     * @return  self
     */ 
    public function setEmail_client($_email_client)
    {
        $this->_email_client = $_email_client;

        return $this;
    }

    /**
     * Get the value of _adresse_client
     */ 
    public function getAdresse_client()
    {
        return $this->_adresse_client;
    }

    /**
     * Set the value of _adresse_client
     *
     * @return  self
     */ 
    public function setAdresse_client($_adresse_client)
    {
        $this->_adresse_client = $_adresse_client;

        return $this;
    }

    /**
     * Get the value of _cp_client
     */ 
    public function getCp_client()
    {
        return $this->_cp_client;
    }

    /**
     * Set the value of _cp_client
     *
     * @return  self
     */ 
    public function setCp_client($_cp_client)
    {
        $this->_cp_client = $_cp_client;

        return $this;
    }

    /**
     * Get the value of _ville_client
     */ 
    public function getVille_client()
    {
        return $this->_ville_client;
    }

    /**
     * Set the value of _ville_client
     *
     * @return  self
     */ 
    public function setVille_client($_ville_client)
    {
        $this->_ville_client = $_ville_client;

        return $this;
    }

    /**
     * Get the value of _tel_client
     */ 
    public function getTel_client()
    {
        return $this->_tel_client;
    }

    /**
     * Set the value of _tel_client
     *
     * @return  self
     */ 
    public function setTel_client($_tel_client)
    {
        $this->_tel_client = $_tel_client;

        return $this;
    }

    /**
     * Get the value of _num_role
     */ 
    public function getNum_role()
    {
        return $this->_num_role;
    }

    /**
     * Set the value of _num_role
     *
     * @return  self
     */ 
    public function setNum_role($_num_role)
    {
        $this->_num_role = $_num_role;

        return $this;
    }
}
