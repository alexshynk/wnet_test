set names utf8;

drop view if exists vclient_services;
drop view if exists vclient_card;
drop table if exists obj_services;
drop table if exists obj_contracts;
drop table if exists obj_customers;



create table obj_customers(
	id_customer int auto_increment primary key,
	name_customer varchar(250),
	company enum('company_1','company_2','company_3')
);

create table obj_contracts(
	id_contract int auto_increment primary key,
	id_customer int,
	number varchar(100),
	date_sign date,
	staff_number varchar(100)
);

create table obj_services(
	id_service int auto_increment primary key,
	id_contract int,
	title_service  varchar(250),
	status enum('work','connecting','disconnected')
);

alter table obj_contracts add constraint fk_customer foreign key (id_customer) references obj_customers(id_customer);
alter table obj_services add constraint fk_contracts foreign key (id_contract) references obj_contracts(id_contract);

-- fill data
insert into obj_customers(name_customer, company) values('customer_1','company_1');
set @id_customer = LAST_INSERT_ID();
insert into obj_contracts(id_customer, number, date_sign, staff_number) values(@id_customer, 101, '2007-07-01', '1001');
set @id_contract = LAST_INSERT_ID();
insert into obj_services(id_contract, status) values(@id_contract, 'work');
insert into obj_services(id_contract, status) values(@id_contract, 'connecting');
insert into obj_services(id_contract, status) values(@id_contract, 'disconnected');

insert into obj_customers(name_customer, company) values('customer_2','company_2');
set @id_customer = LAST_INSERT_ID();
insert into obj_contracts(id_customer, number, date_sign, staff_number) values(@id_customer, 102, '2007-08-01', '1002');
set @id_contract = LAST_INSERT_ID();
insert into obj_services(id_contract, status) values(@id_contract, 'work');
insert into obj_services(id_contract, status) values(@id_contract, 'connecting');
insert into obj_services(id_contract, status) values(@id_contract, 'disconnected');

insert into obj_customers(name_customer, company) values('customer_3','company_3');
set @id_customer = LAST_INSERT_ID();
insert into obj_contracts(id_customer, number, date_sign, staff_number) values(@id_customer, 103, '2007-09-01', '1003');
set @id_contract = LAST_INSERT_ID();
insert into obj_services(id_contract, status) values(@id_contract, 'work');
insert into obj_services(id_contract, status) values(@id_contract, 'connecting');
insert into obj_services(id_contract, status) values(@id_contract, 'disconnected');
insert into obj_contracts(id_customer, number, date_sign, staff_number) values(@id_customer, 104, '2007-10-01', '1004');
set @id_contract = LAST_INSERT_ID();
insert into obj_services(id_contract, status) values(@id_contract, 'work');
insert into obj_services(id_contract, status) values(@id_contract, 'connecting');
insert into obj_services(id_contract, status) values(@id_contract, 'disconnected');

update obj_services set title_service = concat('service - ', id_service);

create view vclient_card
as
select
	cust.id_customer,
	cont.id_contract,
	cust.name_customer,
	cust.company,
	cont.number,
	cont.date_sign
from obj_customers cust
	inner join obj_contracts cont on  cont.id_customer = cust.id_customer
order by cont.id_contract;

create view vclient_services
as
select s.id_contract, s.title_service, s.status
from obj_services s;