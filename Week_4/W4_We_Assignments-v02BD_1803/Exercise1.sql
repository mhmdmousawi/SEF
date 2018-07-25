
/*	Query 1 
*	What is the total number of movies per actor?
*/
SELECT	Concat(A.first_name," ",A.last_name) as Actor,
		count(FA.film_id) as number_of_movies
FROM film_actor as FA
LEFT JOIN actor as A on A.actor_id = FA.actor_id  
group by Actor
order by number_of_movies DESC;

/*	Query 2 
*	What are the top 3 languages for movies released in 2006?
*/
select	L.name as language,
		count(F.film_id) as number_of_films
from film as F
left join language as L on L.language_id = F.language_id
where release_year = 2006
group by L.name
order by number_of_films DESC
limit 3;

/*	Query 3 
*	What are the top 3 countries from which customers are originating?
*/
select	C.country as country,
		count(Cus.customer_id) as number_of_customers
from customer as Cus
left join address as A on A.address_id = Cus.address_id
left join city as City on City.city_id = A.city_id
left join country as C on C.country_id = City.country_id
group by C.country
order by number_of_customers DESC
limit 3;

/*	Query 4 
*	Find all the addresses where the second address is not empty 
*	(i.e., contains some text), and return these second addresses sorted.
*/
select SecondAddresses.address as Address
from(
	select A.address2 as address, count(address_id) as num
	from address as A
	where A.address2 !=  ""
	group by A.address2
	order by num DESC
) as SecondAddresses;

/*	Query 5 
*	Return the first and last names of actors who played in a film 
*	involving a “Crocodile” and a “Shark”, along
*	with the release year of the movie, sorted by the actors’ last names.
*/
select	Concat(A.first_name," ",A.last_name) as actor,
		F.release_year as release_year
from actor as A
left join film_actor as FA on FA.actor_id= A.actor_id
left join film as F on F.film_id = FA.film_id 
where F.description like "%Crocodile%"
and F.description like "%Shark%"
order by A.last_name;


/*	Query 6 
*	Find all the film categories in which there are between 55 and 65 films. 
*	Return the names of these categories and the number of films per category,
*	sorted by the number of films. If there are no categories
*	between 55 and 65, return the highest available counts.
*/
select C.name, count(FC.film_id) as number_of_films
from film_category as FC
left join category as C on C.category_id = FC.category_id
group by FC.category_id
having number_of_films between 55 and 65
UNION ALL
SELECT C.name, count(FC.film_id) as number_of_films
from film_category as FC
left join category as C on C.category_id = FC.category_id
where NOT EXISTS (
					select FC.category_id , count(FC.film_id) as number_of_films
					from film_category as FC
					group by FC.category_id
					having number_of_films between 55 and 65
				)
group by FC.category_id
having number_of_films IN (
							select max(number_of_films) as max_number from 
							(
								select FC.category_id , count(FC.film_id) as number_of_films
								from film_category as FC
								group by FC.category_id
							) as inRange
						)
order by number_of_films;

/*	Query 7
*	Find the names (first and last) of all the actors and costumers 
*	whose first name is the same as the first
*	name of the actor with ID 8. Do not return the actor with ID 8 himself.
*	Note that you cannot use the name of the actor with ID 8 
*	as a constant (only the ID). 
*	There is more than one way to solve this question, 
*	but you need to provide only one solution.
*/
select A.first_name,A.last_name
from actor AS A
where A.first_name = (select first_name from actor where actor_id=8)
and actor_id != 8
union all
select Cus.first_name,Cus.last_name 
from customer as Cus
where Cus.first_name = (select first_name from actor where actor_id=8);

/*	Query 8 
*	Get the total and average values of rentals per month per year per store.
*/

select store.store_id as Store,
		YEAR(R.rental_date) as Year,
        MONTH(R.rental_date) as Month,
		sum(P.amount) as Total,
        avg(P.amount) as Average 
from rental as R
left join payment as P on P.rental_id = R.rental_id
left join staff as S on S.staff_id = R.staff_id
left join store on store.store_id = S.store_id
group by Store,Year,Month
order by Year,Month DESC;

/*	Query 9
*	Get the top 3 customers who rented the highest number of movies 
*	within a given year.
*/
select	Concat(C.first_name," ",C.last_name) as customer,
		YEAR(R.rental_date) as Year,
		count(R.rental_id) as number_of_rentals
from rental as R
left join customer as C on C.customer_id = R.customer_id
-- where YEAR(R.rental_date) = 2006
group by R.customer_id, YEAR(R.rental_date)
order by number_of_rentals DESC
limit 3;