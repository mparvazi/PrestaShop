<?php
/**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShopBundle\Form\Admin\Sell\Address;

use PrestaShop\PrestaShop\Core\Form\ConfigurableFormChoiceProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Defines form for address create/edit actions (Sell > Catalog > Brands & Suppliers)
 */
class ManufacturerAddressType extends AbstractType
{
    /**
     * @var array
     */
    private $manufacturers;

    /**
     * @var array
     */
    private $countries;
    /**
     * @var ConfigurableFormChoiceProviderInterface
     */
    private $statesChoiceProvider;

    /**
     * @var int
     */
    private $defaultCountryId;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param array $manufacturers
     * @param array $countries
     * @param ConfigurableFormChoiceProviderInterface $statesChoiceProvider
     * @param int $defaultCountryId
     * @param TranslatorInterface $translator
     */
    public function __construct(
        array $manufacturers,
        array $countries,
        ConfigurableFormChoiceProviderInterface $statesChoiceProvider,
        $defaultCountryId,
        TranslatorInterface $translator
    ) {
        $this->manufacturers = $manufacturers;
        $this->countries = $countries;
        $this->statesChoiceProvider = $statesChoiceProvider;
        $this->defaultCountryId = $defaultCountryId;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_manufacturer', ChoiceType::class, [
                'choices' => $this->manufacturers,
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('This field cannot be empty', [], 'Admin.Notifications.Error'),
                    ]),
                ],
            ])
            ->add('last_name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('This field cannot be empty', [], 'Admin.Notifications.Error'),
                    ]),
                    new Regex([
                        //@todo: TypedRegexConstraint isName from another PR
                        'pattern' => '/^[^0-9!<>,;?=+()@#"°{}_$%:¤|]*$/u',
                    ]),
                ],
            ])
            ->add('first_name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('This field cannot be empty', [], 'Admin.Notifications.Error'),
                    ]),
                    new Regex([
                        //@todo: TypedRegexConstraint isName from another PR
                        'pattern' => '/^[^0-9!<>,;?=+()@#"°{}_$%:¤|]*$/u',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new Regex([
                        //@todo: TypedRegexConstraint isAddress
                        'pattern' => '/^[^!<>?=+@{}_$%]*$/u',
                    ]),
                ],
            ])
            ->add('address2', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex([
                        //@todo: TypedRegexConstraint isAddress another PR
                        'pattern' => '/^[^!<>?=+@{}_$%]*$/u',
                    ]),
                ],
            ])
            ->add('post_code', TextType::class, [
                'required' => false,
                'constraints' => [
                    //@todo: TypedRegexConstraint isPostcode another PR
                    'pattern' => '/^[a-zA-Z 0-9-]+$/',
                ],
            ])
            //@todo: TypedRegexConstraint isCityName another PR
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('This field cannot be empty', [], 'Admin.Notifications.Error'),
                    ]),
                    new Regex([
                        'pattern' => '/^[^!<>;?=+@#"°{}_$%]*$/u',
                    ]),
                ],
            ])
            ->add('id_country', ChoiceType::class, [
                'required' => true,
                'choices' => $this->countries,
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('This field cannot be empty', [], 'Admin.Notifications.Error'),
                    ]),
                ],
            ])
            ->add('id_state', ChoiceType::class, [
                'required' => false,
                'choices' => $this->statesChoiceProvider->getChoices([
                    'id_country' => $this->defaultCountryId,
                ]),
            ])
            ->add('home_phone', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex([
                        //@todo: TypedRegexConstraint isPhoneNumber another PR
                        'pattern' => '/^[+0-9. ()\/-]*$/',
                    ]),
                ],
            ])
            ->add('mobile_phone', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex([
                        //@todo: TypedRegexConstraint isPhoneNumber another PR
                        'pattern' => '/^[+0-9. ()\/-]*$/',
                    ]),
                ],
            ])
            ->add('other', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex([
                        //@todo: TypedRegexConstraint isMessage another PR
                        'pattern' => '/[<>{}]/i',
                    ]),
                ],
            ])
        ;
    }
}
