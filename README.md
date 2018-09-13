# camagru
### Premier Web Projet Camagru en php de l'Ecole 42

Camagru est un application web permettant de réaliser des montages basiques à l’aide de webcam et d’images prédéfinies.

Un utilisateur de site peut sélectionner une image dans une liste d’images superposables, prendre une photo depuis sa webcam et admirer le résultat d’un montage. Toutes les images prises sont publiques, like-ables et commentables.

Les pages utilise HTML, CSS et JavaScript, Aucun Framework, Micro-Framework ou librairie.

###  Partie commune [fini]
- Serveur web : Apache
- Communiquer avec Base de Données : PDO
- Requêtable : SQL
- Structurer : MVC

### Partie utilisateur [fini]
- permettre à un utilisateur de s’inscrire, en demandant au minimum une adresse email, un nom d’utilisateur et un mot de passe un tant soit peu
sécurisé.
- confirmer son compte via un lien unique envoyé par mail, à l’adresse renseigné dans le formulaire d’inscription.
- ensuite être capable de se connecter avec son nom d’utilisateur et son mot de passe. également pouvoir recevoir un mail de réinitialisation
de son mot de passe en cas d’oubli.
- pouvoir se déconnecter en un seul clic depuis n’importe quelle page du site.
- Une fois connecté, l’utilisateur aura possibilité de modifier son nom d’utilisateur, son adresse mail et son mot de passe.

### Partie galerie [en cours]
- être publique, donc accessible sans authentification. 
- afficher l’intégralité des images prises par les membres du site, triées par date de création. 
- pouvoir permettre à l’utilisateur de les commenter et de les liker si celui-ci est authentifié.
- Lorsque une image reçoit un nouveau commentaire, l’auteur de cette image doit en être informé par mail. Cette préférence est activée par défaut, mais peut être désactivée dans les préférences de l’utilisateur.
- La liste des images doit être paginée, avec au moins 5 éléments par page.
