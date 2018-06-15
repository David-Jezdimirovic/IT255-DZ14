import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from '@angular/http'; 
import { AppComponent } from './app.component';
import { PocetnaComponent } from './stranice/pocetna/pocetna.component';
import { SobeComponent } from './stranice/sobe/sobe.component';
import { KontaktComponent } from './stranice/kontakt/kontakt.component';
import { PretragaSobaComponent } from './stranice/pretraga/pretraga.soba.component';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';
import { SearchpipePipe } from './pipes/search';
import { SortPipe } from './pipes/sort';
import { RoutingModule } from './routing/routing.module';
import { RegistracijaComponent } from './stranice/registracija/registracija.component';
import { DodavanjeSobeComponent } from './stranice/dodavanjeSobe/dodavanjeSobe.component';
import { LoginComponent } from './stranice/login/login.component';
import { NavbarComponent } from './stranice/navbar/navbar.component';
import { RoomComponent } from './stranice/room/room.component';
import { AllroomtypesComponent } from './stranice/allroomtypes/allroomtypes.component';
import { UpdateroomComponent } from './stranice/updateroom/updateroom.component';
import { UpdateroomtypeComponent } from './stranice/updateroomtype/updateroomtype.component';
import { Navbar2Component } from './stranice/navbar2/navbar2.component';




@NgModule({
  declarations: [
    AppComponent,
    PocetnaComponent,
    SobeComponent,
    KontaktComponent,
    PretragaSobaComponent,
    SearchpipePipe,
    SortPipe,
    RegistracijaComponent,
    DodavanjeSobeComponent,
    LoginComponent,
    NavbarComponent,
    RoomComponent,
    AllroomtypesComponent,
    UpdateroomComponent,
    UpdateroomtypeComponent,
    Navbar2Component
    

    
  ],
  imports: [
    BrowserModule,
    HttpModule,
    FormsModule,
    ReactiveFormsModule,
    RoutingModule
 
  ],
  providers: [],
  exports: [SearchpipePipe],
  bootstrap: [AppComponent]
})
export class AppModule { }
