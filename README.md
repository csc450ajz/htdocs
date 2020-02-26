# htdocs
Main repository for Sportrader site -- CSC 450 Capstone Project

## Set up git-ftp
### Prerequisites before install
1. Must have Git installed on Windows and added to PATH (this is usually done by default in Git installation)
2. User login for the site
### Windows
1. Clone directory into a folder: `git clone https://github.com/csc450ajz/htdocs`
2. Start a Git Bash window at the htdocs folder (this is important).
3. Install git-ftp: `curl https://raw.githubusercontent.com/git-ftp/git-ftp/master/git-ftp > /bin/git-ftp`
4. Change permissions on git-ftp folder: `chmod 755 /bin/git-ftp`
5. Configure ftp url: `git config git-ftp.url ftp.sportrader-csp.com`
6. Configure ftp username: `git config git-ftp.user (ftp username -- see Slack)`
7. Configure ftp username: `git config git-ftp.password (ftp password -- see Slack)`
8. Initialize git-ftp: `git ftp init`(may take a few moments)

## Pushing to FTP (Live Site)
1. Make sure all changed files have been pushed and merged with `master` (i.e. do a `git push`)
2. Push updated files to live site: `git ftp push`

Note: In my experience, the `git ftp push` takes a little while to respond. Just wait until it is done.
