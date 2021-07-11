<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFieldType implements FieldTypeInterface
{
    protected array $options;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('name');
        $resolver->setAllowedTypes('name', ['string']);
        $resolver->setDefault('component', null);
        $resolver->setDefault('translatable', false);
        $resolver->setAllowedTypes('component', ['string', 'null']);
        $resolver->setDefault('form_options', []);
        $resolver->setAllowedTypes('form_options', ['array']);
        $this->configureOptions($resolver);
        $formOptions = [];
        foreach ($options as $name => $value) {
            if (!$resolver->isDefined($name)) {
                $formOptions[$name] = $value;
                unset($options[$name]);
            }
        }
        if ($resolver->isDefined('form_options')) {
            $options['form_options'] = $formOptions;
        }
        $this->options = $resolver->resolve($options);
    }

    public function getOption($option)
    {
        return $this->options[$option] ?? null;
    }

    public function getName(): string
    {
        return $this->options['name'];
    }

    public function getComponent(): string
    {
        return $this->options['component'] ?? 'default';
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
    }
}
