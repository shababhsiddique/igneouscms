# igneouscms


This is a simple wrapper/distribution of the versatile CodeIgniter framework. It adds a simple admin panel with minimul cms features out of the box


Features include -

Admin panel ( user: admin@cms.com, pass: admin123)

Wysywig edit your site

File manager/picture manager

My own entity based scaffolding system


# # Live wysywig edit

# # Entity scaffolding


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



