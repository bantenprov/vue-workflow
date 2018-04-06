# vue-workflow

[![Join the chat at https://gitter.im/vue-workflow/Lobby](https://badges.gitter.im/vue-workflow/Lobby.svg)](https://gitter.im/vue-workflow/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/vue-workflow/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/vue-workflow/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/vue-workflow/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/vue-workflow/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/vue-workflow/v/stable)](https://packagist.org/packages/bantenprov/vue-workflow)
[![Total Downloads](https://poser.pugx.org/bantenprov/vue-workflow/downloads)](https://packagist.org/packages/bantenprov/vue-workflow)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/vue-workflow/v/unstable)](https://packagist.org/packages/bantenprov/vue-workflow)
[![License](https://poser.pugx.org/bantenprov/vue-workflow/license)](https://packagist.org/packages/bantenprov/vue-workflow)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/vue-workflow/d/monthly)](https://packagist.org/packages/bantenprov/vue-workflow)
[![Daily Downloads](https://poser.pugx.org/bantenprov/vue-workflow/d/daily)](https://packagist.org/packages/bantenprov/vue-workflow)

Manage workfow using vuejs


## Install via composer :

```bash
$ composer require bantenprov/vue-workflow:dev-master
```

## Module ini membutuhkan `vue-guard`

### install `vue guard` dan `vue trust`:
```bash
$ composer require bantenprov/vue-guard:dev-master
$ composer require bantenprov/vue-trust:dev-master
```
### Konfigurasi vue guard :
<a href="https://github.com/bantenprov/vue-guard" target="_blank">Dokumentasi Vue Guard</a>

### Konfigurasi vue trust :
<a href="https://github.com/bantenprov/vue-trust" target="_blank">Dokumentasi Vue Trust</a>

### Setelah install serta kofigurasi `vue-guard` dan `vue-trust` lanjutkan untuk konfigurasi `vue-workflow` :

## Edit `config/app.php`

```php

'providers' => [        

        //....
        Emadadly\LaravelUuid\LaravelUuidServiceProvider::class,
        Bantenprov\VueWorkflow\VueWorkflowServiceProvider::class,

```

## Artisan command :

```bash

$ php artisan vendor:publish --tag=vue-workflow-config
$ php artisan vendor:publish --tag=vue-workflow-assets
$ php artisan migrate
$ php artisan vue-workflow:publish-trait

```


### Cara penggunaan

Copy code dibawah ke component vue.
pada contoh di bawah ini digunakan pada component `Pendaftaran.show.vue` module `Pendaftaran`

```javascript

<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Show pendaftaran {{ model.label }}

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">
        <div class="form-row">
          <div class="col-md">
            <b>Label :</b> {{ model.label }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Description :</b> {{ model.description }}
          </div>
        </div>

        <div class="form-row mt-4">
            <div class="col-md">
                <b>Username :</b> {{ model.user.name }}
            </div>
        </div>

        <div class="form-row mt-4">
            <div class="col-md">
                <b>Kegiatan :</b> {{ model.kegiatan.label }}
            </div>
        </div>

        <!-- component vue-workfow  -->
        <workflow-process content-type="Pendaftaran"></workflow-process>
        <!-- end component vue-workfow-->
      </vue-form>
    </div>
  </div>
</template>

```


