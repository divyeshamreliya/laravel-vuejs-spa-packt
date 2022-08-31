# Product List + Filters In Laravel Vue Js

Single App Web Page For Product List + Filters In Laravel Vue Js

<a href="https://github.com/divyeshamreliya/laravel-vuejs-spa-packt/actions"><img src="https://github.com/divyeshamreliya/laravel-vuejs-spa-packt/blob/master/.github/workflows/packt-1.png" alt="Sample Image"></a>
<a href="https://github.com/divyeshamreliya/laravel-vuejs-spa-packt/actions"><img src="https://github.com/divyeshamreliya/laravel-vuejs-spa-packt/blob/master/.github/workflows/packt-2.png" alt="Sample Image"></a>
## Installation

- `git clone https://github.com/divyeshamreliya/laravel-vuejs-spa-packt.git`
- `composer install`
- Copy `.env.example` to `.env` file `cp .env.example .env`
- Edit `.env` and set your database connection details
- (When installed via git clone or download, run `php artisan key:generate`)
- `php artisan migrate`
- `npm install`
- (To fetch packtd prdocuts, run `php artisan product:fetch` - This command will take 15-20 minutes as we are fetching product from packtd api and store it in our database)
- Run vue js `npm run dev`
- Run laravel project `php artisan serve`
