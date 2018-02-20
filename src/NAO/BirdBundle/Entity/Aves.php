<?php

namespace NAO\BirdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aves
 *
 * @ORM\Table(name="aves")
 * @ORM\Entity(repositoryClass="NAO\BirdBundle\Repository\AvesRepository")
 */
class Aves
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="regne", type="string", length=8)
     */
    private $regne;

    /**
     * @var string
     *
     * @ORM\Column(name="phylum", type="string", length=8)
     */
    private $phylum;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=4)
     */
    private $classe;

    /**
     * @var string
     *
     * @ORM\Column(name="ordre", type="string", length=19)
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=17)
     */
    private $famille;

    /**
     * @var string
     *
     * @ORM\Column(name="group1_inpn", type="string", length=7)
     */
    private $group1Inpn;

    /**
     * @var string
     *
     * @ORM\Column(name="group2_inpn", type="string", length=7)
     */
    private $group2Inpn;

    /**
     * @var int
     *
     * @ORM\Column(name="cd_nom", type="integer")
     */
    private $cdNom;

    /**
     * @var string
     *
     * @ORM\Column(name="cd_taxsup", type="string", length=6)
     */
    private $cdTaxsup;

    /**
     * @var string
     *
     * @ORM\Column(name="cd_sup", type="string", length=6)
     */
    private $cdSup;

    /**
     * @var int
     *
     * @ORM\Column(name="cd_ref", type="integer")
     */
    private $cdRef;

    /**
     * @var string
     *
     * @ORM\Column(name="rang", type="string", length=4)
     */
    private $rang;

    /**
     * @var string
     *
     * @ORM\Column(name="lb_nom", type="string", length=47)
     */
    private $lbNom;

    /**
     * @var string
     *
     * @ORM\Column(name="lb_auteur", type="string", length=73)
     */
    private $lbAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_complet", type="string", length=86)
     */
    private $nomComplet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_complet_html", type="string", length=93)
     */
    private $nomCompletHtml;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_valide", type="string", length=86)
     */
    private $nomValide;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_vern", type="string", length=101)
     */
    private $nomVern;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_vern_eng", type="string", length=122)
     */
    private $nomVernEng;

    /**
     * @var string
     *
     * @ORM\Column(name="habitat", type="string", length=1)
     */
    private $habitat;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set regne
     *
     * @param string $regne
     *
     * @return Aves
     */
    public function setRegne($regne)
    {
        $this->regne = htmlspecialchars($regne);

        return $this;
    }

    /**
     * Get regne
     *
     * @return string
     */
    public function getRegne()
    {
        return $this->regne;
    }

    /**
     * Set phylum
     *
     * @param string $phylum
     *
     * @return Aves
     */
    public function setPhylum($phylum)
    {
        $this->phylum = htmlspecialchars($phylum);

        return $this;
    }

    /**
     * Get phylum
     *
     * @return string
     */
    public function getPhylum()
    {
        return $this->phylum;
    }

    /**
     * Set classe
     *
     * @param string $classe
     *
     * @return Aves
     */
    public function setClasse($classe)
    {
        $this->classe = htmlspecialchars($classe);

        return $this;
    }

    /**
     * Get classe
     *
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     *
     * @return Aves
     */
    public function setOrdre($ordre)
    {
        $this->ordre = htmlspecialchars($ordre);

        return $this;
    }

    /**
     * Get ordre
     *
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Aves
     */
    public function setFamille($famille)
    {
        $this->famille = htmlspecialchars($famille);

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set group1Inpn
     *
     * @param string $group1Inpn
     *
     * @return Aves
     */
    public function setGroup1Inpn($group1Inpn)
    {
        $this->group1Inpn = htmlspecialchars($group1Inpn);

        return $this;
    }

    /**
     * Get group1Inpn
     *
     * @return string
     */
    public function getGroup1Inpn()
    {
        return $this->group1Inpn;
    }

    /**
     * Set group2Inpn
     *
     * @param string $group2Inpn
     *
     * @return Aves
     */
    public function setGroup2Inpn($group2Inpn)
    {
        $this->group2Inpn = htmlspecialchars($group2Inpn);

        return $this;
    }

    /**
     * Get group2Inpn
     *
     * @return string
     */
    public function getGroup2Inpn()
    {
        return $this->group2Inpn;
    }

    /**
     * Set cdNom
     *
     * @param integer $cdNom
     *
     * @return Aves
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = htmlspecialchars($cdNom);

        return $this;
    }

    /**
     * Get cdNom
     *
     * @return integer
     */
    public function getCdNom()
    {
        return $this->cdNom;
    }

    /**
     * Set cdTaxsup
     *
     * @param string $cdTaxsup
     *
     * @return Aves
     */
    public function setCdTaxsup($cdTaxsup)
    {
        $this->cdTaxsup = htmlspecialchars($cdTaxsup);

        return $this;
    }

    /**
     * Get cdTaxsup
     *
     * @return string
     */
    public function getCdTaxsup()
    {
        return $this->cdTaxsup;
    }

    /**
     * Set cdSup
     *
     * @param string $cdSup
     *
     * @return Aves
     */
    public function setCdSup($cdSup)
    {
        $this->cdSup = htmlspecialchars($cdSup);

        return $this;
    }

    /**
     * Get cdSup
     *
     * @return string
     */
    public function getCdSup()
    {
        return $this->cdSup;
    }

    /**
     * Set cdRef
     *
     * @param integer $cdRef
     *
     * @return Aves
     */
    public function setCdRef($cdRef)
    {
        $this->cdRef = htmlspecialchars($cdRef);

        return $this;
    }

    /**
     * Get cdRef
     *
     * @return integer
     */
    public function getCdRef()
    {
        return $this->cdRef;
    }

    /**
     * Set rang
     *
     * @param string $rang
     *
     * @return Aves
     */
    public function setRang($rang)
    {
        $this->rang = htmlspecialchars($rang);

        return $this;
    }

    /**
     * Get rang
     *
     * @return string
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set lbNom
     *
     * @param string $lbNom
     *
     * @return Aves
     */
    public function setLbNom($lbNom)
    {
        $this->lbNom = htmlspecialchars($lbNom);

        return $this;
    }

    /**
     * Get lbNom
     *
     * @return string
     */
    public function getLbNom()
    {
        return $this->lbNom;
    }

    /**
     * Set lbAuteur
     *
     * @param string $lbAuteur
     *
     * @return Aves
     */
    public function setLbAuteur($lbAuteur)
    {
        $this->lbAuteur = htmlspecialchars($lbAuteur);

        return $this;
    }

    /**htmlspecialchars(
     * Get lbAuteur
     *
     * @return string
     */
    public function getLbAuteur()
    {
        return $this->lbAuteur;
    }

    /**
     * Set nomComplet
     *
     * @param string $nomComplet
     *
     * @return Aves
     */
    public function setNomComplet($nomComplet)
    {
        $this->nomComplet = htmlspecialchars($nomComplet);

        return $this;
    }

    /**
     * Get nomComplet
     *
     * @return string
     */
    public function getNomComplet()
    {
        return $this->nomComplet;
    }

    /**
     * Set nomCompletHtml
     *
     * @param string $nomCompletHtml
     *
     * @return Aves
     */
    public function setNomCompletHtml($nomCompletHtml)
    {
        $this->nomCompletHtml = htmlspecialchars($nomCompletHtml);

        return $this;
    }

    /**
     * Get nomCompletHtml
     *
     * @return string
     */
    public function getNomCompletHtml()
    {
        return $this->nomCompletHtml;
    }

    /**
     * Set nomValide
     *
     * @param string $nomValide
     *
     * @return Aves
     */
    public function setNomValide($nomValide)
    {
        $this->nomValide = htmlspecialchars($nomValide);

        return $this;
    }

    /**
     * Get nomValide
     *
     * @return string
     */
    public function getNomValide()
    {
        return $this->nomValide;
    }

    /**
     * Set nomVern
     *
     * @param string $nomVern
     *
     * @return Aves
     */
    public function setNomVern($nomVern)
    {
        $this->nomVern = htmlspecialchars($nomVern);

        return $this;
    }

    /**
     * Get nomVern
     *
     * @return string
     */
    public function getNomVern()
    {
        return $this->nomVern;
    }

    /**
     * Set nomVernEng
     *
     * @param string $nomVernEng
     *
     * @return Aves
     */
    public function setNomVernEng($nomVernEng)
    {
        $this->nomVernEng = htmlspecialchars($nomVernEng);

        return $this;
    }

    /**
     * Get nomVernEng
     *
     * @return string
     */
    public function getNomVernEng()
    {
        return $this->nomVernEng;
    }

    /**
     * Set habitat
     *
     * @param string $habitat
     *
     * @return Aves
     */
    public function setHabitat($habitat)
    {
        $this->habitat = htmlspecialchars($habitat);

        return $this;
    }

    /**
     * Get habitat
     *
     * @return string
     */
    public function getHabitat()
    {
        return $this->habitat;
    }
}
