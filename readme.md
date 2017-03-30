# Phinest Version API

This is the backend code of the original http://phinestversion.com site. The
code has been refactored as an external API which the client interfaces with
(https://github.com/Blankenship-Daniel/phinestversion-client). The available
requests are publicly accessible if any other application wants to build off
of this data.

Along with refactoring the backend as an API, many of the queries have been
optimized to decrease page loading times. A list of available requests are
outlined below.

## Description

Over the past 32 years Phish has played 596 versions of “You Enjoy Myself,” 498 versions of “Mike’s Song,” 465 “David Bowies,” 442 versions of “Run Like An Antelope” and 374 versions of “Reba.” For a new fan getting into the band, figuring out where to start can be a tough slog. A new site called Phinest Version aims to figure out the best of the best by crowd sourcing rankings for both songs and shows.

Phinest Version allows fans to submit their favorite versions of songs and shows, vote up and down and comment on other submissions. The key to the success of the site relies on Phish fans participating and using Phinest Version as intended. As such, we suggest you register and login to Phinest Version to share your thoughts.

-https://www.jambase.com/article/phinest-version-aims-to-crowd-source-phish-ratings

You can access Phinest Version 1.0 here: http://phinestversion.com

## Requests

## GET requests

### Songs

* `/songs`
* `/songs/rankings`
* `/songs/{id}`
* `/songs/{slug}`
* `/songs/rankings`
* `/songs/rankings/{slug}`

### Shows

* `/shows`
* `/shows/{id}`
* `/shows/{date}`
* `/shows/rankings`
* `/shows/rankings/{year}`
* `/shows/rankings/{date}`

### Years

* `/years/rankings`
* `/years/rankings/{year}`

### Venues

* `/venues`
* `/venues/{id}`
* `/venues/{slug}`

### Comments

* `/comments`
* `/comments/{id}`
* `/comments/user/{id}`
* `/comments/submission/{id}`
* `/comments/count/submission/{id}`

### Submissions

* `/submissions`
* `/submissions/{id}`
* `/submissions/song/{id}`
* `/submissions/slug/{slug}`
* `/submissions/show/{id}`
* `/submissions/user/{id}`
* `/submissions/user/{username}`
* `/submissions/rankings/{date}`

### Votes

* `/votes`
* `/votes/user/{id}`
* `/votes/submission/{id}`
* `/votes/type`

### Users

* `/users`
* `/users/rankings`
* `/users/{id}`
* `/users/{username}`
