import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PocetnaComponent } from '../stranice/pocetna/pocetna.component';
import { SobeComponent } from '../stranice/sobe/sobe.component';
import { PretragaSobaComponent } from '../stranice/pretraga/pretraga.soba.component';
import { KontaktComponent } from '../stranice/kontakt/kontakt.component';
import { DodavanjeSobeComponent } from '../stranice/dodavanjeSobe/dodavanjeSobe.component';
import { RegistracijaComponent } from '../stranice/registracija/registracija.component';
import { LoginComponent } from '../stranice/login/login.component';
import { AllroomtypesComponent } from '../stranice/allroomtypes/allroomtypes.component';
import { RoomComponent } from '../stranice/room/room.component';
import { UpdateroomComponent } from '../stranice/updateroom/updateroom.component';
import { UpdateroomtypeComponent } from '../stranice/updateroomtype/updateroomtype.component';


const routes: Routes = [
   //{ path: '', component: PocetnaComponent}, //index stranica
   { path: '', redirectTo: 'pocetna', pathMatch: 'full'}, // redirekcija na pocetnu stranicu
   { path: 'pocetna', component: PocetnaComponent },
   { path: 'sobe', component: SobeComponent },
   { path: 'pretraga', component: PretragaSobaComponent },
   { path: 'allroomtypes', component: AllroomtypesComponent },
   { path: 'kontakt', component: KontaktComponent },
   { path: 'dodavanjeSobe', component: DodavanjeSobeComponent },
   { path: 'registracija', component: RegistracijaComponent },
   { path: 'login', component: LoginComponent },
   { path: 'room/:id', component: RoomComponent },
   { path: 'updateroom/:id', component: UpdateroomComponent },
   { path: 'updateroomtype/:id', component: UpdateroomtypeComponent }
];

@NgModule({
    imports: [
        RouterModule.forRoot(routes)
    ],
    exports: [
        RouterModule
    ],
    declarations: []
})

export class RoutingModule { }
