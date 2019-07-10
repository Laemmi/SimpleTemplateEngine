[![Build Status](https://travis-ci.org/Laemmi/simple-template-engine.svg?branch=master)](https://travis-ci.org/Laemmi/simple-template-engine)
[![Latest Stable Version](https://poser.pugx.org/laemmi/simple-template-engine/v/stable)](https://packagist.org/packages/laemmi/simple-template-engine)
[![Total Downloads](https://poser.pugx.org/laemmi/simple-template-engine/downloads)](https://packagist.org/packages/laemmi/simple-template-engine)
[![Latest Unstable Version](https://poser.pugx.org/laemmi/simple-template-engine/v/unstable)](https://packagist.org/packages/laemmi/simple-template-engine)
[![License](https://poser.pugx.org/laemmi/simple-template-engine/license)](https://packagist.org/packages/laemmi/simple-template-engine)

# Simple template engine
This is very simple template engine to parse templates.

## Requirements
php 7.2

## Installation
via composer
    composer require laemmi/simple-template-engine
or use repository
    git clone https://github.com/Laemmi/simple-template-engine.git
    
## Usage
    $template = TemplateFactory::factory('My name is {if $name}{#name#}{/if} and i am {#age#} years old.');
    $template->assign('name', 'Michael');
    $template->assign('age', 99);
    $template->render();
