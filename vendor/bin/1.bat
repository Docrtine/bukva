 call doctrine-module orm:convert-mapping annotation module/User/src/ --namespace="User\Entity\\" --from-database
call doctrine-module orm:generate-entities module/User/src/ --generate-annotations=true