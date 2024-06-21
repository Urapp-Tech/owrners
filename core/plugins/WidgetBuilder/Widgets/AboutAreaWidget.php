<?php

namespace plugins\WidgetBuilder\Widgets;

use plugins\FormBuilder\SanitizeInput;
use plugins\PageBuilder\Fields\Image;
use plugins\PageBuilder\Fields\Repeater;
use plugins\PageBuilder\Fields\Textarea;
use plugins\PageBuilder\Fields\Text;
use plugins\PageBuilder\Helpers\RepeaterField;
use plugins\PageBuilder\Traits\LanguageFallbackForPageBuilder;
use plugins\WidgetBuilder\WidgetBase;

class AboutAreaWidget extends WidgetBase
{
    use LanguageFallbackForPageBuilder;

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= Image::get([
            'name' => 'image',
            'label' => __('Site Logo'),
            'value' => $widget_saved_values['image'] ?? null,
            'dimensions' => '173x41'
        ]);

        $output .= Textarea::get([
            'name' => 'description',
            'label' => __('Description'),
            'value' => $widget_saved_values['description'] ?? null,
        ]);

        $output .= Repeater::get([
            'settings' => $widget_saved_values,
            'id' => 'social_icon',
            'fields' => [
                [
                    'type' => RepeaterField::ICON_PICKER,
                    'name' => 'icon',
                    'label' => __('Icon')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'url',
                    'label' => __('Url')
                ],
            ]
        ]);

        $output .= Repeater::get([
            'settings' => $widget_saved_values,
            'id' => 'contact_info',
            'fields' => [
                [
                    'type' => RepeaterField::ICON_PICKER,
                    'name' => 'icon',
                    'label' => __('Icon')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'info',
                    'label' => __('Contact Info')
                ],
            ]
        ]);

        
        $output .= Text::get([
            'name' => 'address',
            'label' => __('Address'),
            'value' => $widget_saved_values['address'] ?? null,
        ]);


        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $settings = $this->get_settings();
        $logo = render_image_markup_by_attachment_id($settings['image']);
        $address = purify_html($settings['address']);
        $description = purify_html($settings['description']);
        $route = route('homepage');
        $repeater_data = $settings['social_icon'];
        $social_icon_markup = '';

        foreach ($repeater_data['icon_'] as $key => $icon) {
            $icon = SanitizeInput::esc_html($icon);
            $url = SanitizeInput::esc_html($repeater_data['url_'][$key]);
            $social_icon_markup.= <<<SOCIALICON
            <li class="footer-widget-social-list-item">
                <a class="footer-widget-social-list-link" href="{$url}"> <i class="{$icon}"></i> </a>
            </li>

SOCIALICON;
        }

        $contact_repeater_data = $settings['contact_info'];
        $contact_info_markup = '';

        foreach ($contact_repeater_data['icon_'] as $key => $icon) {
            $icon = SanitizeInput::esc_html($icon);
            $info = SanitizeInput::esc_html($contact_repeater_data['info_'][$key]);
            $contact_info_markup .= <<<CONTACTINFO
             <span class="footer-widget-contact-item"> 
                <span> 
                 <i class="{$icon}"></i> 
                 </span>
                <a href="javascript:void()"> {$info} </a> 
             </span>

        CONTACTINFO;
        }

        return <<<HTML
           <div class="col-lg-3 col-sm-6 mt-4">
                    <div class="footer-widget widget">
                        <div class="footer-contents-logo">
                            <a href="{$route}" class="footer-contents-logo-img-custom"> 
                            {$logo}
                            </a>
                        </div>
                        <div class="footer-widget-inner mt-4">
                            <p class="footer-widget-para">{$description}</p>
                            <h6 class="footer-widget-about-custom-heading">Follow Us</h6>
                            <div class="footer-widget-social mt-2">
                                <ul class="footer-widget-social-list list-style-none">
                                    {$social_icon_markup}
                                </ul>
                            </div>
                            <div class="footer-widget-about-custom-contact mt-2">
                                <h6 class="footer-widget-about-custom-heading">Contact</h6>
                                <div class="d-flex justify-content-between " style="width:90%">
                                    {$contact_info_markup}
                                </div>
                            </div>
                            <div class="footer-widget-about-custom-about mt-2">
                                <h6 class="footer-widget-about-custom-heading">Address</h6>
                                <div>
                                    {$address}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        HTML;
    }

    public function widget_title()
    {
        return __('About Area (Custom Widget)');
    }

}
