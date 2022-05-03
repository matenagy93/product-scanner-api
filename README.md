## About Product Scanner API

With this Laravel based API you are able to access the products in the database and calculate the price of a scanning session (cart).
Currently, you are able to test the product on this link: [How to use](https://scanner-api.nagynet.eu/)

## Set up in 2 steps

**First step**: After cloning, you need to create a database and set up the environmental variables (base: .env-own.example):
- App URL
- Database connection
- Current sales tax, price currency and price signal (change if needed)

**Second step**: do a database migration with seeding (`php artisan migrate:fresh --seed`)

After that, you are able the use the API, store your own products, etc.
The 'How to use' information is stored in the resources/view, it will show the onepage website on your own domain.