TEAM MEMBERS

- Shuhuai Cao(sqc6247)
- Simin Wang(skw5680)
- Shuyue Qiao(svq5058)


FILES

- Config.php: Stores database configurations like host, username and password.
- index.php: The main entry of the system, will redirect to other pages based on current state.
- license.html: Shows MIT license of Bootstrap framework.
- login.php: The login page. Doctors and patients can enter their credentials here.
- login_action.php: Executes SQL queries using data submitted from login.php. Will redirect to other pages based on login state.
- logout.php: Clear everything in session and redirect to login page.
- register.php: Patients can create their accounts here.
- register_insert.php: The page that executes insert statement to create an account.
- pat_center.php: User center for patients. Patients can edit their profiles, manage medical and allergy history, and view visit records.
- pat_center_action.php: Contains functions to add and delete records in patient center.
- edit_user.php: Patients can edit their profiles here.
- edit_user_action.php: Executes SQL update statements for updating patient profiles.
- app_detail.php: Shows details of a visit, including date, comment, information of patient and doctor, and prescriptions.
- doc_center.php: User center for doctors. Doctors can add visit records in this page.
- search_patient.php: Doctors can pick a patient from this list and create a visit record.
- search_patient_action.php: Returns search result based on keyword and page.
- create_pres.php: Shows details of the patient. A visit record will be created after the doctor enters comment and submits the form.
- create_pres_action.php: Database operations of create_pres.php.
- search_medicine.php: Doctors pick a medicine from this list and create a prescription.
- search_medicine_action.php: Database operations for selecting medicines and creating prescriptions.
- js/*.js: Use ajax to obtain data and update DOMs in order to avoid frequent page refreshing.
- sql/create.sql: The SQL statements used to create the tables and add indexes.

DATA SOURCES
-


CHANGES

- ID fields of all tables except for patient,doctor and drug table has change to int type and set to auto increment. Changing this to int and auto increment does not need us to set an ID manually when inserting a record.
- Added company name and usage fields to drug table. We obtained a data set of medicines from FDA’s website. In our opinion, adding these fields will make the system more professional.
- In order to make the design closer to real life, we added a table called “appointment”, and it contains ID of itself, patient’s ID, doctor’s ID and appointment date.
