<template>
    <v-list>
        <v-list-item-content>
              <v-list-item-title>FINANCIERA S.A. de C.V.</v-list-item-title>
              <v-list-item-subtitle>El mejor prestamo para ti</v-list-item-subtitle>
            </v-list-item-content>
      
        <v-list-item dark to="/">
            <v-list-item-icon>
                <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Home</v-list-item-title>
        </v-list-item>

        <v-list-item dark to="/clients">
            <v-list-item-icon>
            <v-icon>mdi-badge-account-horizontal</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Clients</v-list-item-title>
        </v-list-item>

        <v-list-item dark to="/prestamos">
        <v-list-item-icon>
            <v-icon>mdi-cash-usd</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Prestamos</v-list-item-title>
        </v-list-item>

        <v-list-item dark to="/pagos">
        <v-list-item-icon>
            <v-icon>mdi-credit-card-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Pagos</v-list-item-title>
        </v-list-item>

        <v-list-item dark to="/about">
            <v-list-item-icon>
            <v-icon>mdi-map-marker-question</v-icon>
            </v-list-item-icon>
            <v-list-item-title>About</v-list-item-title>
        </v-list-item>
    </v-list>
</template>
