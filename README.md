 # ParisLumiere 
 
 By @riff4, @dmignon1907 and @alexandrospopov.

 ## Introduction
 
 During the course of Data Visualisation we were given the opportunity to design an interactive data exploration tool. 
 
 For us, is was foremost a way to dig into data exploration and tool designing. We wanted to choose a subject that would provide rich data and would match our personal interests. 
 Quickly, we noticed that we shared an interest in Cinema and we really focused in this field. 
 
 One dataset that we liked instantly was the [Paris Movie Shooting Records](https://opendata.paris.fr/explore/dataset/tournagesdefilmsparis2011/table/?refine.type_de_tournage=LONG+METRAGE&location=11,48.84663,2.34995) fro m the Paris Open Data website.
  It provided us with the basic data of every shot made in Paris in 2016. Choosing a movie, we were able to see where it had been shot in Paris. 
 
 There were so many questions we could finally answer ! What movies have been shot close to my work or my home ? Where are the movies shot in winter and in spring ? Are movies only in touristic areas ? Where are shot the best movies in Paris ? Does any director know about my most romantic spot in Paris ..? 
 
 The decision had been made : we would design a tool to discover how directors see our City of Lights.
 
 ## Data Acquisition
 
 ### Sources of information 
 
 Our initial source of information ist the [Paris Movie Shooting Records](https://opendata.paris.fr/explore/dataset/tournagesdefilmsparis2011/table/?refine.type_de_tournage=LONG+METRAGE&location=11,48.84663,2.34995) that we have exported as a `JSON` file. 
 This first input provided us with the following information for every shot :
  - **title**
  - **director**
  - shot adress
  - company
  - **type of the movie shot**
  - **district**
  - **date of beginning** 
  - **date of ending** 
  - **latitude/longitude**
  
 It is worth noticing that this adress the shot for different types of motion pictures : movie, but also series and TV shows. 
 We decided to focus only on movies. In terms of figures, our dataset is made of : 
 - 118 movies
 - 1851 shots
 
 Unfortunately this first database is not enough for us. We wished to be able to analyse information from the movies, for instance its Genre, ratings, popularity and so on.  
 To obtain this information, we used the imDB API : [tmDB](https://www.themoviedb.org/documentation/api). 
 imDB is one the largest movie database available on the Internet, so its API seemed appropriate for our project. It gives many informations for many movies. Asking information about Fight Club lead for instance to this [page](https://api.themoviedb.org/3/movie/550?api_key=ca4eaa0dc3f34672b121a95ed7a74541).
 
 Still, we have to havekeep in mind that this database is US-oriented, so it is very possible that french movies are not as well documented as Fight Club.
 
 ### Data fusion and corrections
 
 At this point we have the Paris Open Data `JSON` file and the tmDB API. 
 In order to add to every movie in the Paris Open Data its tmDB information; we will proceed in several steps.
 
 At first, we will query the API though the Python Package : [tmDB Simple](https://pypi.python.org/pypi/tmdbsimple) using the movie title. 
 
 This first step provides a great amount of new data. But it needs processing. In deed we face two kinds of issues : 
 - **several movies for one title** : the API provides several references for one title. We have to choose manually which one is the right one. 
 - **missing information** : as we have feared, tmDB is unable to provide us with all the information we have dreamed of. In some cases because the database is uncomplete, in other cases because the information does not exist yet: the movie is not out or has been canceled. 
 
 The second issue leads us to carefully choose what information we wish to add to every movie. We decided to add only the genre and the ratings. 
 To deal with the latter issue, we chose to inspect manually every movie with missing information ( about 40 out of 115) and add manually if it exists using the site [SensCritique](https://www.senscritique.com/).
 
 This entire pipeline has handled using Python.
 
 ### Data presentation
 
 Finally, we reach the following dataset :
 
| Movies | Shots | Movies with missing information |
| ------------- | ------------- | ------------- |
| 118  | 1851 | 39 (33%) |

 
 ## Graphic Design 
 
 ## Using the Tool 
 
 ## Interesting results
 
 ## Perspectives & Conclusion
