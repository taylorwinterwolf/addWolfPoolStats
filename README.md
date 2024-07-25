This is a PHP application I made to take in statistics for a local pool league I play in. 

I load the index.php script on a local server I start by running the command php -S localhost:8000 in the terminal of VS Code. The index.php file is a dynamic form that takes in data and submits the data to submitStats.php. 

submitStats.php is where all of the raw data is parsed and calls functions from the dataAPI.php file. 

The dataAPI.php file adds new stats and players to JSON files that I write to. I chose to write to JSON files because in another seperate project, I use them to upload the data to my firestore(Firebase) database. 

I like submitting and parsing my data locally, I don't have to connect to any databases and when the JSON files are generated, they are very easy to use when importing the data to firestore. 

I chose PHP for this project because of it's ability to loop through multipul itterations of HTML display components, this way on the index page Im not writing the same code over and over. I also love that I can run and use PHP scripts on my local computer with very little set up.

It's lightweigh and effective