# igneouscms

Igneous CMS is a bootstrap for codeigntier framework. offering a out of the box admin panel,  minimul cms features out of the box and easy to use scaffodling system

Developed by -

shababhsiddique


=======
License
=======
Copyright (c) 2016, Shabab Haider Siddique
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.



===========
Application
===========

This project is currently the startup bootstrap of all my codeigniter applications. As it allows to put up the application framework pretty quickly.


I will put up a list of sites that currently use this CMS soon.


=========
Thanks To
=========

I thank all the developers and contributor to the codeigniter and all its side libraries.

The libraries / third party codes used in this project are -

datatables jquery plugin

ignited datatables (datatable for ci)

dgtree (for tree menu)

kcfinder (for file finder)

nicedit (for edit toolbar in cms)

tinymce (for text editor)

jquery

bootstrap


and ofcourse codeigniter itself


Thanks to everyone involved on the above projects, without them this project would be near impossible.



Special thanks to "lumextech" the software company that holds this cms as its go to bootstrap platform for php applications.



=========
Features 
=========

Features include -

Admin panel ( user: admin@cms.com, pass: admin123)

Wysywig edit your site

File manager/picture manager

My own entity based scaffolding system


======== Live wysywig edit

Wysywig edit of site is based on the text block function. The text block modules allows u to put an editable text anywhere in your website. This peice of text will be availble for wysywig when u are on admin mode.


======== Entity scaffolding


To create a new entity / class / whatever u want to call. The steps are easy -

1) Create the database table for it , the definition and data types are important

2) go to application -> models -> admin -> entity_model.php 

3) add a new entity to define ur table

Here is the example model definition of a simple entity called "email"

    public function email() {
        
        $entity = array(
            "select" => array(
                "tbl_emails.email_id" => "number####",
                "tbl_emails.email" => "varchar####required|email"
            ),
            "from" => 'tbl_emails',
            "action_key" => 'tbl_emails.email_id',
            "actions" => array(
                "delete" => "quickdelete/tbl_emails/email_id"
            )
        );

        return $entity;
    }



The first parameter inside the $entity array is "select" which will take an associative array where the key is the column name and the value is the type of data followed by 4 hash (we will cover it later). Followed by the form validation (optional) rules

The second parameter is "from" which will take the table name

The third is "action_key" which will take the primary key for this table

The fourth is "actions" which will take an associative array with the key as "actions" and  the values as the url of that action appended by the primary key ( written earlier under action_key )


The above piece of code will create  all the necessary pages you need to create / view / delete emails. You can see this in action under admin panel -> subscribers



In order to create a new entity / class like this just copy paste the template and change the corresponding field of the array



