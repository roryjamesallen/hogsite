# Custom Repository & Domain
1. Create your repository on GitHub, ideally with the same name as you want the URL to be, plus 'site' (e.g. stevesite if you want steve.hogwild.uk).
1. Clone the repository to your local machine (e.g. `git clone git@github.com:steve/stevesite.git`.
1. Generate an SSH key on your local machine and give Rory the public key, along with the clone URL for your repository and what domain you want (e.g. 'please can I have steve.hogwild.uk, here is my repository URL and here is my public SSH key').
1. Run `git remote set-url --add --push origin ssh://wildhog@hogwild.uk:9284/home/wildhog/repository` to add the live site as a remote to be pushed to as well as GitHub (when you run `git push` you'll now update both GitHub *and* the live site). Replace `repository` in that command with the actual name of your repository.
1. Now edit your site and then commit the changes, and run `git push` to update your repository on GitHub and your live site.
