Le projet

Existant : logiciel CardiffVHU -> Gestion de pièces pour les entreprises de VHU ( voir sur internet une meilleure def + capture d'écran interface principale )

Explication projet :  Interface permettant aux clients de se connecter à un espace privé et d'envoyer des photos sur un serveur relié au logiciel. L'interface devra être utilisable sur smartphone et tablette afin que le client puisse prendre des photos rapidement et les retrouver sur le logiciel. Le lien avec le logiciel se fait via l'API développé au sein de ce même projet.

Avantages : possibilité de prendre des photos rapidement et "sur le vif", les enregistrer directement et les avoir à dispo instantanément depuis un smartphone, une table ou une site web + dans le logiciel. Connexion simple et rapide avec pseudo+mdp. L'espace admin permet à CardiffVHU de créer les espaces clients et de leur donner leurs identifiants sans que les clients n'aient à le faire.

Inconvénients : Pas possible d'ouvrir la webcam pour prendre une photo depuis un poste fix car le nouveaux navigateurs ne supporte pas cette invasion si le site n'est pas en https.

Construction

Structure : Page authentification -> home client avec les dossiers et la possibilité d'en ajouter -> photos rangées par dossiers et possibilité d'en ajouter
	ou Page authentification -> home admin avec liste des clients, possibilité de modifier et/ou supprimer + création de nouveau(x) compte(s)

Fonctionnalités : 
			Pour le client
					-affichages des dossiers par nom ( ordre alphabétique )
					- création de dossiers
					- recherche de dossiers par noms
					- upload de photos ( possibilité d'upload multiple depuis une bibliothèque locale pour plus de rapidité ) et prise de photo ( ouverture de la camera et enregistrement )
					- suppression de dossier ou de photo
			Pour l'admin
					- affichage de la liste des clients par nom et @
					- création d'un client
					- modification d'un client
					- suppression d'un client
 
