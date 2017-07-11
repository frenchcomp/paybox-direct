<?php

namespace Nexy\PayboxDirect\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
trait ID3DTrait
{
    /**
     * @var string|null
     *
     * @Assert\Length(min=1, max=20)
     */
    private $id3d = null;

    /**
     * @param string|null $id3d
     *
     * @return $this
     */
    final public function setID3D($id3d = null)
    {
        $this->id3d = $id3d;

        return $this;
    }

    /**
     * @return array
     */
    private function getID3DParameters()
    {
        $parameters = [];
        if ($this->id3d !== null) {
            $parameters['ID3D'] = $this->id3d;
        }

        return $parameters;
    }
}
