create table address
(
    address_id int auto_increment
        primary key,
    street     varchar(50) not null,
    city       varchar(50) not null,
    state      varchar(50) not null,
    country    varchar(50) not null
);

create table allergy_history
(
    id           int auto_increment
        primary key,
    patient_id   varchar(50)  not null,
    allergy_name varchar(50)  not null,
    description  varchar(200) not null
);

create table appointment
(
    app_id     int auto_increment
        primary key,
    doctor_id  varchar(50) not null,
    patient_id varchar(50) not null,
    app_date   date        not null
);

create table attendence
(
    attendance_id   int auto_increment
        primary key,
    doctor_id       varchar(50)  not null,
    patient_id      varchar(50)  not null,
    attendence_date date         not null,
    comment         varchar(200) not null
);

create table department
(
    department_id int auto_increment
        primary key,
    dname         varchar(50) not null
);

create table doctor
(
    doctor_id     varchar(50)  not null
        primary key,
    password      varchar(50)  not null,
    fname         varchar(50)  not null,
    mname         varchar(50)  null,
    lname         varchar(50)  not null,
    department_id int          not null,
    gender        varchar(50)  not null,
    level         int          not null,
    email         varchar(200) not null
);

create index doc_index
    on doctor (fname, mname, lname, email);

create table drug
(
    drug_id      varchar(50)  not null
        primary key,
    price        float        not null,
    name         varchar(500) not null,
    stock        int          not null,
    company_name varchar(450) null,
    `usage`      varchar(450) null
);

create index drug_index
    on drug (name);

create table level
(
    level_id   int auto_increment
        primary key,
    level_name varchar(50) not null
);

create table medical_history
(
    medical_history_id int auto_increment
        primary key,
    patient_id         varchar(50)  null,
    disease_name       varchar(50)  not null,
    description        varchar(200) not null
);

create table patient
(
    patient_id varchar(50)  not null
        primary key,
    fname      varchar(20)  not null,
    mname      varchar(20)  null,
    lname      varchar(20)  not null,
    address_id varchar(20)  null,
    gender     varchar(50)  null,
    password   varchar(50)  not null,
    birthday   date         null,
    email      varchar(200) not null
);

create index pat_index
    on patient (fname, mname, lname, email);

create table prescription
(
    prescription_id int auto_increment
        primary key,
    attendence_id   int          not null,
    drug_id         varchar(20)  not null,
    specification   varchar(200) null,
    number          int          not null
);