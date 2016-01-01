<?php

/*
 * This file is part of the EasyAdminBundle.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer;

use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer\ActionNormalizer;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer\DefaultNormalizer;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer\EntityNormalizer;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer\FormViewNormalizer;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer\PropertyNormalizer;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer\TemplateNormalizer;
use JavierEguiluz\Bundle\EasyAdminBundle\Configuration\Normalizer\ViewNormalizer;

/**
 * It applies several configuration normalizers in a row to transform any
 * input backend configuration into the normalized configuration used by
 * the rest of the code.
 *
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class ConfigurationNormalizer implements NormalizerInterface
{
    /** @var NormalizerInterface[] */
    private $normalizers;

    public function __construct($kernelRootDir)
    {
        $this->normalizers = array(
            new EntityNormalizer(),
            new FormViewNormalizer(),
            new ViewNormalizer(),
            new PropertyNormalizer(),
            new ActionNormalizer(),
            new TemplateNormalizer($kernelRootDir),
            new DefaultNormalizer(),
        );
    }

    public function normalize(array $backendConfiguration)
    {
        foreach ($this->normalizers as $normalizer) {
            $backendConfiguration = $normalizer->normalize($backendConfiguration);
        }

        return $backendConfiguration;
    }
}
