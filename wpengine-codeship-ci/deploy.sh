# Check for required codeship environment variables and make sure they are setup
: ${WPE_INSTALL_PROD?"WPE_INSTALL_PROD Missing"}   # subdomain for wpengine production install
: ${REPO_NAME?"REPO_NAME Missing"}       # repo name (name of the repo, duh)

# In WP Engine's multi-environment setup, we'll target each instance based on branch with variables to designate them individually.
if [[ "$CI_BRANCH" == "master" && -n "$WPE_INSTALL_PROD" && -z "$WPE_INSTALL" ]]
then
    target_wpe_install=${WPE_INSTALL_PROD}
    repo=production
fi

if [[ "$CI_BRANCH" == "staging" && -n "$WPE_INSTALL_STAGE" ]]
then
    target_wpe_install=${WPE_INSTALL_STAGE}
    repo=production
fi

if [[ "$CI_BRANCH" == "develop" && -n "$WPE_INSTALL_DEV" ]]
then
    target_wpe_install=${WPE_INSTALL_DEV}
    repo=production
fi

# run build process
npm install
gulp build

# Stage, commit, and push to wpengine repo
git remote add ${repo} git@git.wpengine.com:${repo}/${target_wpe_install}.git

git config --global user.email CI_COMMITTER_EMAIL
git config --global user.name CI_COMMITTER_NAME
git config core.ignorecase false

git add --all
git commit -am "Deployment to ${target_wpe_install} $repo by $CI_COMMITTER_NAME from $CI_NAME"

git push -f ${repo} master