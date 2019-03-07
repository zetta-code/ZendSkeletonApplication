<?php
/**
 * @link      http://github.com/zetta-code/zend-skeleton-application for the canonical source repository
 * @copyright Copyright (c) 2018 Zetta Code
 */

namespace Application\Controller;

use Application\Enum\Configuration;
use Zend\Filter\File\RenameUpload;
use Zend\Form\Element;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ArrayUtils;
use Zend\Validator\File;
use Zend\View\Model\ViewModel;
use Zetta\ZendBootstrap\Form\SettingsForm;

/**
 * Class SettingsController
 */
class SettingsController extends AbstractActionController
{

    public function indexAction()
    {
        $general = [
            'name',
            'shortname',
            'email',
            'phone',
            'hotsite',
        ];
//        $defaults = $this->settings()->get('defaults');
        $files = [
            'css-custom',
            'favicon',
            'brand',
            'brand-white',
            'reports' => [
                'brand'
            ]
        ];
        $features = $this->settings()->get('features');
        $payment = $this->settings()->get('services', 'payment');
        $reports = $this->settings()->get('reports')->toArray();
        $settings = [];


        foreach ($general as $key) {
            $settings[$key] = [
                'name' => Configuration::DESCRICOES[$key],
                'value' => $this->settings()->get($key),
            ];
        }

//        foreach ($defaults as $key => $value) {
//            $settings[$key] = [
//                'name' => Configuration::DESCRICOES[$key],
//                'value' => $value ?: 0,
//            ];
//        }

        foreach ($features as $key => $value) {
            $settings[$key] = [
                'name' => Configuration::DESCRICOES[$key],
                'value' => $value,
            ];
        }

        foreach ($payment as $key => $value) {
            if ($key === 'campus') continue;

            $settings['payment-' . $key] = [
                'name' => Configuration::DESCRICOES[$key],
                'value' => $value,
            ];
            if ($key === 'system') {
                $settings['payment-' . $key]['value_options'] = [
                    'iugu' => 'iugu',
                    'pagseguro' => 'PagSeguro',
                    'uninovafapi' => 'Uninovafapi Pagamentos',
                ];
            }
        }

        unset($reports['brand']);
        foreach ($reports as $key => $value) {
            $settings[$key] = [
                'name' => Configuration::DESCRICOES[$key],
                'value' => $value,
            ];
        }

        $form = new SettingsForm(['settings' => $settings]);
        $form->setAttribute('action', $this->url()->fromRoute('home/default', ['controller' => 'settings']));
        $this->addFileInputs($form);

        if ($this->request->isPost()) {
            $post = ArrayUtils::merge(
                $this->request->getPost()->toArray(), $this->request->getFiles()->toArray()
            );
            $form->setData($post);
            if ($form->isValid()) {
                $this->settings()->setOverride(true);
                $data = $form->getData();
                foreach ($general as $key) {
                    $this->settings()->put($key, $data['settings'][$key]['value']);
                }
//                foreach ($defaults as $key => $value) {
//                    $this->settings()->put('defaults', $key, $data['settings'][$key]['value']);
//                }
                foreach ($files as $index => $key) {
                    if (is_array($key)) {
                        foreach ($key as $k) {
                            $longKey = $index . '-' . $k;
                            if (isset($data[$longKey]['error']) && $data[$longKey]['error'] === UPLOAD_ERR_OK && isset($data[$longKey]['tmp_name'])) {
                                $this->settings()->put($index, $k, substr($data[$longKey]['tmp_name'], 8));
                            }
                        }
                    } else {
                        if (isset($data[$key]['error']) && $data[$key]['error'] === UPLOAD_ERR_OK && isset($data[$key]['tmp_name'])) {
                            $this->settings()->put($key, substr($data[$key]['tmp_name'], 8));
                        }
                    }
                }
                foreach ($features as $key => $value) {
                    $this->settings()->put('features', $key, $data['settings'][$key]['value']);
                }
                foreach ($payment as $key => $value) {
                    if ($key === 'campus') continue;

                    $this->settings()->put('services', 'payment', $key, $data['settings']['payment-' . $key]['value']);
                }
                foreach ($reports as $key => $value) {
                    $this->settings()->put('reports', $key, $data['settings'][$key]['value']);
                }

                $this->flashMessenger()->addSuccessMessage(_('Configurações atualizadas com sucesso!'));
                return $this->redirect()->refresh();
            } else {
                $this->flashMessenger()->addErrorMessage(_('Configuração com erro!'));
            }
        }

        $viewModel = new ViewModel([
            'form' => $form,
            'general' => $general,
            'defaults' => [],
            'features' => $features,
            'payment' => $payment,
            'reports' => $reports,
        ]);

        return $viewModel;
    }

    /**
     * @param SettingsForm $form
     */
    public function addFileInputs($form)
    {
        $form->add([
            'name' => 'css-custom',
            'type' => Element\File::class,
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => _('CSS Custom'),
                'label_attributes' => ['class' => 'control-label'],
                'div' => ['class' => 'form-group', 'class_error' => 'has-error'],
            ],
        ]);
        $form->add([
            'name' => 'favicon',
            'type' => Element\File::class,
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => _('Icon'),
                'label_attributes' => ['class' => 'control-label'],
                'div' => ['class' => 'form-group', 'class_error' => 'has-error'],
            ],
        ]);
        $form->add([
            'name' => 'brand',
            'type' => Element\File::class,
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => _('Brand'),
                'label_attributes' => ['class' => 'control-label'],
                'div' => ['class' => 'form-group', 'class_error' => 'has-error'],
            ],
        ]);
        $form->add([
            'name' => 'brand-white',
            'type' => Element\File::class,
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => _('White brand'),
                'label_attributes' => ['class' => 'control-label'],
                'div' => ['class' => 'form-group', 'class_error' => 'has-error'],
            ],
        ]);
        $form->add([
            'name' => 'reports-brand',
            'type' => Element\File::class,
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => _('Black brand'),
                'label_attributes' => ['class' => 'control-label'],
                'div' => ['class' => 'form-group', 'class_error' => 'has-error'],
            ],
        ]);

        $form->getInputFilter()->add([
            'name' => 'css-custom',
            'required' => false,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => './public/uploads/custom.css',
                        'overwrite' => true,
                    ]
                ]
            ],
            'validators' => [
                [
                    'name' => File\UploadFile::class
                ],
                [
                    'name' => File\Extension::class,
                    'options' => [
                        'extension' => 'css',
                    ],
                ],
            ]
        ]);
        $form->getInputFilter()->add([
            'name' => 'favicon',
            'required' => false,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => './public/uploads/favicon',
                        'use_upload_extension ' => true,
                        'overwrite' => true,
                    ]
                ]
            ],
            'validators' => [
                [
                    'name' => File\UploadFile::class
                ],
                [
                    'name' => File\Extension::class,
                    'options' => [
                        'extension' => ['png', 'jpg', 'jpeg', 'gif', 'svg', 'ico'],
                    ],
                ],
                [
                    'name' => File\Size::class,
                    'options' => [
                        'max' => '5MB',
                    ],
                ],
            ]
        ]);
        $form->getInputFilter()->add([
            'name' => 'brand',
            'required' => false,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => './public/uploads/brand',
                        'use_upload_extension ' => true,
                        'overwrite' => true,
                    ]
                ]
            ],
            'validators' => [
                [
                    'name' => File\UploadFile::class
                ],
                [
                    'name' => File\Extension::class,
                    'options' => [
                        'extension' => ['png', 'jpg', 'jpeg', 'gif', 'svg'],
                    ],
                ],
                [
                    'name' => File\Size::class,
                    'options' => [
                        'max' => '5MB',
                    ],
                ],
            ]
        ]);
        $form->getInputFilter()->add([
            'name' => 'brand-white',
            'required' => false,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => './public/uploads/brand-white',
                        'use_upload_extension ' => true,
                        'overwrite' => true,
                    ]
                ]
            ],
            'validators' => [
                [
                    'name' => File\UploadFile::class
                ],
                [
                    'name' => File\Extension::class,
                    'options' => [
                        'extension' => ['png', 'jpg', 'jpeg', 'gif', 'svg'],
                    ],
                ],
                [
                    'name' => File\Size::class,
                    'options' => [
                        'max' => '5MB',
                    ],
                ],
            ]
        ]);
        $form->getInputFilter()->add([
            'name' => 'reports-brand',
            'required' => false,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => './public/uploads/reports-brand',
                        'use_upload_extension ' => true,
                        'overwrite' => true,
                    ]
                ]
            ],
            'validators' => [
                [
                    'name' => File\UploadFile::class
                ],
                [
                    'name' => File\Extension::class,
                    'options' => [
                        'extension' => ['png', 'jpg', 'jpeg', 'gif', 'svg'],
                    ],
                ],
                [
                    'name' => File\Size::class,
                    'options' => [
                        'max' => '5MB',
                    ],
                ],
            ]
        ]);
    }
}
