<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageConfig
 *
 * @ORM\Table(name="image_config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageConfigRepository")
 */
class ImageConfig
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
     * @ORM\Column(name="background", type="string", length=255, nullable=true)
     */
    private $background;

    /**
     * @var string
     *
     * @ORM\Column(name="foreground", type="string", length=255, nullable=true)
     */
    private $foreground;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="font", type="string", length=255, nullable=true)
     */
    private $font;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroundSource", type="string", length=255, nullable=true)
     */
    private $backgroundSource;


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
     * Set background
     *
     * @param string $background
     *
     * @return ImageConfig
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set foreground
     *
     * @param string $foreground
     *
     * @return ImageConfig
     */
    public function setForeground($foreground)
    {
        $this->foreground = $foreground;

        return $this;
    }

    /**
     * Get foreground
     *
     * @return string
     */
    public function getForeground()
    {
        return $this->foreground;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return ImageConfig
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set font
     *
     * @param string $font
     *
     * @return ImageConfig
     */
    public function setFont($font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * Get font
     *
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set backgroundSource
     *
     * @param string $backgroundSource
     *
     * @return ImageConfig
     */
    public function setBackgroundSource($backgroundSource)
    {
        $this->backgroundSource = $backgroundSource;

        return $this;
    }

    /**
     * Get backgroundSource
     *
     * @return string
     */
    public function getBackgroundSource()
    {
        return $this->backgroundSource;
    }
}

