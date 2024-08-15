<?php

namespace Nexy\PayboxDirect\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
trait ID3DTrait
{
    /**
     * @Assert\Length(min=1, max=20)
     */
    private ?string $id3d = null;

    final public function setID3D(string $id3d = null): self
    {
        $this->id3d = $id3d;

        return $this;
    }

    private function getID3DParameters(): array
    {
        $parameters = [];
        if (null !== $this->id3d) {
            $parameters['ID3D'] = $this->id3d;
        }

        return $parameters;
    }
}
