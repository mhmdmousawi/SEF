

--Query 1 (What is the total number of movies per actor?)
SELECT Concat(A.first_name," ",A.last_name), count(FA.film_id)
from film_actor as FA
join actor as A on A.actor_id = FA.actor_id  
group by Concat(A.first_name," ",A.last_name);

--Query 2 (What are the top 3 languages for movies released in 2006?)
select L.name, count(F.film_id) as filmCount
from film as F
left join language as L on L.language_id = F.language_id
where release_year = 2006
group by L.name
order by filmCount DESC
limit 3

--Query 3 (What are the top 3 countries from which customers are originating?)
select C.country,count(Cus.customer_id)
from customer as Cus
left join address as A on A.address_id = Cus.address_id
left join city as City on City.city_id = A.city_id
left join country as C on C.country_id = City.country_id
group by C.country
order by count(Cus.customer_id) DESC
limit 3

--Query 4 (Find all the addresses where the second address is not empty 
--(i.e., contains some text), and return these second addresses sorted.)
select SecondAddresses.address from(
select A.address2 as address, count(address_id) as num
from address as A
where A.address2 !=  ""
group by A.address2
order by num DESC
) as SecondAddresses