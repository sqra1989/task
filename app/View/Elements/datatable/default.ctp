<?php

//var_dump($dtResults);exit;

$c = $config->columns;
//$c = $dtColumns;

foreach ($dtResults as $result) {
    $new = [];
    foreach ($c as $key => $val) {
        if (isset($val['actions'])) {
            $akcje = '';
            foreach ($val['actions'] as $akcja => $ustawienia) {
                if (is_string($ustawienia)) {
                    $akcja = $ustawienia;
                    $ustawienia = [];
                }

                if (!isset($ustawienia['id'])) {
                    $ustawienia['id'] = $config->model . "." . 'id';
                }

                $link = Hash::extract($result, $ustawienia['id']);
                $link['action'] = $akcja;
                if (isset($ustawienia['link'])) {
                    $link = array_merge($link, $ustawienia['link']);
                }

                $name = $akcja;
                if (isset($ustawienia['name'])) {
                    $name = $ustawienia['name'];
                }

                $class = 'btn btn-xs';

                if (isset($ustawienia['class'])) {
                    $class .= " " . $ustawienia['class'];
                }

                $options = array('class' => $class);

                if (isset($ustawienia['options'])) {
                    $options = array_merge($options, $ustawienia['options']);
                }

                $helper = "Html";
                if (isset($ustawienia['helper'])) {
                    $helper = $ustawienia['helper'];
                }
                
                switch ($akcja) {
                    case 'delete':
                        $question = 'Are you sure you want to delete %s?';
                        if (isset($ustawienia['question'])) {
                            $question = $ustawienia['question'];
                        }

                        $question_value = null;
                        if (isset($ustawienia['question_value'])) {
                            $question_value = Hash::get($result, $ustawienia['question_value']);
                        }

//                        $akcje .= $this->Form->postLink(
//                                __($name), $link, $options, __($question, $question_value)
//                        );
                        $options['class'] = 'btn btn-xs red ajax post';
                        $options['data-question'] = __($question);
                        $options['data-question-value'] = __($question_value);
                        $akcje .= $this->Html->link(
                                __($name), $link, $options
                        );
                        break;
                    case 'edit':
                    default:
                        $akcje .= $this->Html->link(
                                __($name), $link, $options
                        );
                }
            }
            $new[] = $akcje;
        } else if (isset($val['virtual'])) {
            $new[] = Hash::get($result, "0." . $key);
        } else if (isset($val['get'])) {
            $out = [];
            if (is_array($val['get'])) {
                foreach ($val['get'] as $key => $val) {
                    $out[$key] = Hash::get($result, $val);
                }
            } else {
                $out = Hash::get($result, $val['get']);
            }
            $new[] = $out;
        } else if (isset($val['extract'])) {
            $out = [];
            if (is_array($val['extract'])) {
                foreach ($val['extract'] as $key => $val) {
                    $out[$key] = Hash::extract($result, $val);
                }
            } else {
                $out = Hash::extract($result, $val['extract']);
            }
            $new[] = $out;
        } else {
            //$x = excplode(".",$key,2);
            $new[] = Hash::get($result, $key); //$result[$x[0]][$x[1]];   
        }
    }
    $this->dtResponse['aaData'][] = $new;
}
if ($config->debug) {
    $this->dtResponse['debug']['results'] = $dtResults;
    $this->dtResponse['debug']['config'] = $config;
    $this->dtResponse['debug']['rawconfig'] = $rawconfig;
    $this->dtResponse['debug']['custom'] = $customdebug;
}