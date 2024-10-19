# simple shopping website 

a single-page react shopping website , with smooth and reactive front-end and back end done in php and graphql api 

## features 

### functionality 
1. **Body**
    - I. **product album**
        - * the default view of the webiste body
        - * a list of the vendors products is shown on the form of card albums following the pattern of popular e-commerce websites
        - * each card has a quick shop button if the product is in stock
        - * smooth animiations on hover
        - * clicking on a product cards takes you to product details 
    - II **product detatils** 
        - * contains the details of the product
        - * an image gallery of the product 
            - A. the product main image is shown with maximum width and height of the image carousl
            - B. the other images are in form of a image slider which can be clicked or swiped using arrows on the main image
        - * product name is shown as a header 
        - * product attributes are shown and selectable 
        - * product description 
        - * product price 
        - * place order button to add product to cart ( only clickable after selecting product options)
        - * each product has it's own link so that it can be shared
2. **Header**
    - I. **categroies**
        - * products are divided by categories and clicking on a category link filters the list to the corrosponding products
        - * each category has it's own link so it can be shared 
    - II. **cart**
        - * products can be added to cart in two ways by placing an order in product details or using quick shop button
            - A. quick shop adds the product with default options
            - B. place order adds the product with the selected options 
        - * order details 
            - A. each product is shown with it's quantity and it's options 
            - B. the quantity can be increased or decreased if decrased to zero the product is deleted
            - C. the options are'nt selectable and same products with diffrent options are added sepratly 
            - D. adding the same product with the same options just incremnts the orders quantatity 
        - * total price is shown and is the some of the order cost 
        - * the send order button regiesters the order in the database for further operations 

## Future Plans

i am looking forward to adding authentication , and a home page for the webiste 

## website link 

the website is hosted on infinity free you can check it out it handels mostly all screen sizes and is reactive 

https://mohamedfathyzaky.free.nf/build/?i=1

## Acknowledgments

- this was a task i done for scaniweb while i applying for a role it was a very productive process 
- infinity free where i hosted my website 

## source codes 

the files are in the src folder containg each code for the back_end and the front_end the back_end is done in php and graphql api each class is implemented in it's class file 
so the code is eaisly readable and reusable 