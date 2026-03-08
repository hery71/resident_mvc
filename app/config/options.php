<?php
return [
    'Gender' => ['Homme', 'Femme', 'NC'],
    'Relation' => ['Epoux','Epouse','Grands parents', 'Père', 'Mère', 'Frère', 'Sœur', 'Cousin(e)', 'Ami/Oncle', 'Tante', 'Fils', 'Fille', 'Petit Fils', 'Petite fille'],
    'CauseDepart' => ['Décès', 'Déménagement', 'Maladie', 'Autre'],
    'Commentaires' => ['CAKE FOR RESIDENTS','CAKE FOR THE STAFF','CAKE FOR THE PARTY','WAITING CONFIRMATION','CAKE FOR RESIDENTS','GIVE THE CAKE TO FAMILY','FAMILY WILL BRING CAKE','NO PARTY FAMILLY PICK UP THE CAKE','NO CAKE'],
    'Heure' => ['13:30:00','14:00:00','14:30:00','15:00:00','15:30:00','16:00:00','16:30:00','17:00:00'],
    'Lieux' => ['Salle Activite','Salon','Gazebo','Chambre','NO PARTY'],
    'Observations' => [ 'Confirmed','Subject to modification','Family no answer'],
    'Informations' => [ 'No','Family clean and throw all after party Send all disposables'],
    //********************************cuisine************************************************** */
    'Juice' => ['Orange', 'Canneberge', 'Pommes', 'Autres'],
    'Prune' => ['Puree', 'Jus'],
    'Sucre' => ['Sucre','Artificiel'],
    'Eggs' => ['Bouilli', 'Omelette', 'Fricassée', 'Brouillé'],
    'Milk' => ['Grand', 'Moyen', 'Petit'],
    //********************************DIETETICIEN************************************************** */
    'Bread' => ['Roti ble entier', 'Roti pain blanc', 'Pain ble entier' , 'Pain Blanc'],
    'Tartinade' => ['Confiture','Beurre d arachide','Beurre','Margarine'],
    'Cereale' => ['Cereales chaudes', 'Cereales froides', 'Muffin'],
    'Proteine' => ['Oeuf','Fromage','Custard','Bacon'],
    'Fruit' => ['Fraise','prune','Autre'],
    'Breuvage' => ['The','Cafe','Lait 1Oz', 'Lait 8Oz','Sucre 1cc','Sucre Artificiel','Eau' ,'Eau 8Oz','Jus 4Oz'],
    'LieuRepas' => ['Cafeteria', 'Activité', 'Chambre', 'Salon'],

    //********************************infirmier************************************************** */
    'Consistance' => ['Normale', 'Purée', 'Haché','Liquide','Coupe'],
    'ModeEating' => ['Autonome', 'Feeding'],
    'Thickened' => ['0', '1', '2', '3', '4'],
    'Diabet' => ['Oui', 'Non'],
    'Lactose' => ['Normale', 'Sans lactose'],
    //********************************fetes************************************************** */
    'Motif' => ['Birthday', 'Requiem', 'Familiale','Autre'],
    'Couleur' => ['Bleu', 'Rose', 'Jaune', 'Vert', 'Rouge', 'Blanc', 'Multicolore'],
    //*****************************************STAFF********************************************* */
    'status' => ['FT', 'PT', 'OCC', 'ETUDIANT', 'CONTRAT', 'STAGE'],
    'Sevice' => ['Service alimentaire et Menage', 'Soins', 'Autre'],
    'Departement' => [  'Service alimentaire et Menage' =>  ['Menage','Cuisine','Laundry'],
                        'Soins'                         =>  ['soins1','soins2','soins3'] 
                    ],
    'Poste' => ['COOK', 'MAID','UT','POLY'],
    'DayOff' => ['SM', 'WD','V','F','HA','CUPE'],
    'Hour' => ['3', '3.75','4.75','5.5','6.5','7.5','8.5','9.5','10.25','11.25']
];
?>
