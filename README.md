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

# `ℹ️` untuk saat ini module workflow hanya berjalan di module pendaftaran ( test version )

## Install via composer :

```bash
$ composer require bantenprov/vue-workflow:dev-master
```

## Module ini membutuhkan `vue-guard` dan `vue-trust`

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

### Edit `resources/assets/js/router/routes.js`

```javascript
{
      path: '/admin',
      name: 'admin',
      redirect: '/admin/dashboard',
      component: layout('Default'),
      children: [
        /* workflow route */      
        {
        path: '/admin/workflow',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.index.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Workflow"
        }
        },
        {
        path: '/admin/workflow/create',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.create.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Workflow | add"
        }
        },
        {
        path: '/admin/workflow/:id/show',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.show.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Workflow | show worfklow"
        }
        },
        {
        path: '/admin/workflow/:id/edit',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.edit.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Workflow | show worfklow"
        }
        },
        {
        path: '/admin/workflow/state',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/state/state.index.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "State"
        }
        },
        {
        path: '/admin/workflow/transition',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.index.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Transition"
        }
        },
        {
        path: '/admin/workflow/state/create',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/state/state.create.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "State | add new state"
        }
        },
        {
        path: '/admin/workflow/state/:id/edit',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/state/state.edit.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "State | edit state"
        }
        },
        {
        path: '/admin/workflow/transition',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.index.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Transition"
        }
        },
        {
        path: '/admin/workflow/transition/create',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.create.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Tranisiton | add transition"
        }
        },
        {
        path: '/admin/workflow/transition/:id/edit',
        components: {
          main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.edit.vue'], resolve),
          navbar: resolve => require(['~/components/Navbar.vue'], resolve),
          sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
        },
        meta: {
          title: "Tranisiton | edit tranisiton"
        }
        },
        /* end workflow route */
```

### Edit `resources/assets/js/app.js`

```javascript

//==== workflow menu
import workflow_menu from './components/bantenprov/vue-workflow/workflow_menu';

```

### Edit `resources/assets/js/components.js`

```javascript

//== vue workflow process component

import WorkflowProcess from '~/components/views/bantenprov/vue-workflow/WorkflowProcess.vue';
Vue.component('workflow-process', WorkflowProcess);

```

### Cara penggunaan

Copy code dibawah ke component vue.
pada contoh di bawah ini digunakan pada component `Pendaftaran.show.vue` module `Pendaftaran`

Component workflow :

`<workflow-process content-type="ContentType"></workflow-process>`

props :
- content-type : Nama Model yang digunakan oleh module

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

### Edit `config/vue-workflow.php`

```php

'content_type' => [        
        ['id' => 1,'label' => 'Pendaftaran'],
    ]

```
`ℹ️` jika content_type lebih dari satu
key (`id`) menggunakan angka yang berurutan

contoh untuk penggunaan content type lebih dari satu

```php

'content_type' => [        
        ['id' => 1,'label' => 'Pendaftaran'],
        ['id' => 2,'label' => 'Siswa'],
    ]

```

### Edit controller

pada contoh ini yang di gunakan adalah module pendaftaran, jadi yang di edit adalah
`vendor/bantenprov/pendaftaran/Http/Controllers/Http/PendaftaranController.php`


`Tabahkan use trait ini` :

```php
/* Use Workflow Trait */
use Bantenprov\VueWorkflow\Http\Traits\WorkflowTrait;

/**
 * The PendaftaranController class.
 *
 * @package Bantenprov\Pendaftaran
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PendaftaranController extends Controller
{  
    /* Use Workflow Trait */
    use WorkflowTrait;

```

`Pada method store` :

```php

/**
  * Display the specified resource.
  *
  * @param  \App\Pendaftaran  $pendaftaran
  * @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    $pendaftaran = $this->pendaftaran;

    $validator = Validator::make($request->all(), [
        'kegiatan_id' => 'required',
        'user_id' => 'required|max:16|unique:pendaftarans,user_id',
        'label' => 'required|max:16|unique:pendaftarans,label',
        'description' => 'max:255',
    ]);

    if($validator->fails()){

        $check = $pendaftaran->where('label',$request->label)->orWhere('user_id', $request->user_id)->whereNull('deleted_at')->count();

        if ($check > 0) {
            $response['message'] = 'Failed, label or user already exists';
        } else {
            /*
              $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
              $pendaftaran->user_id = $request->input('user_id');
              $pendaftaran->label = $request->input('label');
              $pendaftaran->description = $request->input('description');                
              $pendaftaran->save();
            */

            /* Ganti dengan code di bawah ini */
            $this->insertWithWorkflow($pendaftaran, $request->all());

            $response['message'] = 'success';
        }
    } else {

        /*
          $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
          $pendaftaran->user_id = $request->input('user_id');
          $pendaftaran->label = $request->input('label');
          $pendaftaran->description = $request->input('description');        
          $pendaftaran->save();
        */

        /* Ganti dengan code di bawah ini */

        $this->insertWithWorkflow($pendaftaran, $request->all());

        $response['message'] = 'success';
    }

    $response['status'] = true;

    return response()->json($response);
}

```

`Pada method update` :

```php

public function update(Request $request, $id)
{
    $response = array();
    $message = array();

    $validator = Validator::make($request->all(), [
        'label' => 'required|unique:pendaftarans,label,'.$id,
        'user_id' => 'required|unique:pendaftarans,user_id,'.$id,            
        'kegiatan_id' => 'required',
        'description' => 'required'
    ]);

    if($validator->fails()){            
        foreach($validator->messages()->getMessages() as $key => $error){
            foreach($error AS $error_get) {
                array_push($message, $error_get);
            }                
        }   

        $get_request = $this->pendaftaran->find($id);

        $check_label = $this->pendaftaran->where('id','!=', $id)->where('label', $request->label);

        $check_user = $this->pendaftaran->where('id','!=', $id)->where('user_id', $request->user_id);

        if($check_label->count() > 0 || $check_user->count() > 0){
            $response['message'] = implode("\n",$message);
        }else{
            /*
              $pendaftaran->label = $request->input('label');
              $pendaftaran->description = $request->input('description');
              $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
              $pendaftaran->user_id = $request->input('user_id');
              $pendaftaran->save();

              $response['message'] = 'success';
            */

            /* Ganti dengan code dibawah ini */

            $update = $this->updateWithWorkflow($this->pendaftaran->find($id), $id, $request->all());

            $response['message'] = $update['message'];
        }


    }else{

        /*
          $pendaftaran->label = $request->input('label');
          $pendaftaran->description = $request->input('description');
          $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
          $pendaftaran->user_id = $request->input('user_id');
          $pendaftaran->save();

          $response['message'] = 'success';
        */

        /* Ganti dengan code dibawah ini */

        $update = $this->updateWithWorkflow($this->pendaftaran->find($id), $id, $request->all());

        $response['message'] = $update['message'];
    }

    $response['status'] = true;

    return response()->json($response);
}

```

### Untuk melakukan pengujian

```bash

$ php artisan make:model Department -m

```

Edit file `databases/miggrations/timestap_create_departments_table.php`

```php

Schema::create('departments', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id');
    $table->integer('kegiatan_id');
    $table->string('name');
    $table->timestamps();
});

```

Edit file `app/Department.php`

```php

class Department extends Model
{
    protected $fillable = ['user_id', 'kegiatan_id', 'name'];

}

```

untuk pengujian isi secara manual pada table departments ,

```
+----+---------+-------------+--------------+
| id | user_id | kegiatan_id |     name     |
+----+---------+-------------+--------------+
|  1 |    1    |      1      | Department 1 |
+----+---------+-------------+--------------+
|  2 |    2    |      2      | Department 2 |
+----+---------+-------------+--------------+
```

setelah itu edit file `app/Http/Controllers/Traits/WorkflowConditionTrait.php`

```php
<?php

namespace App\Http\Controllers\Traits;
use App\Department;

/**
 * Trait WorkflowConditionTrait
 * @package App\Http\Controllers\Traits
 */
trait WorkflowConditionTrait
{    

    /**
     * @return bool
     */

    public function guard__propose_to_review($content_id){

        $check = \Bantenprov\Pendaftaran\Models\Bantenprov\Pendaftaran\Pendaftaran::find($content_id);
        $department = Department::where('kegiatan_id',$check->kegiatan_id)->first();
        if($department->user_id == \Auth::user()->id){
              return [
                  'error' => true,
                  'message' => 'Success update state.'
              ];
        }else{
              return [
                  'error' => true,
                  'message' => 'tidak mempunyai akses untuk ini.'
              ];
        }        

    }

}
```
