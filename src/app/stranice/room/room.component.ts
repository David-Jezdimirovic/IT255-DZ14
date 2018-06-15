import { Component, OnInit } from '@angular/core';
import { Directive } from '@angular/core'; 
//import { FormGroup, FormControl } from '@angular/forms';
import { Http, Response, Headers } from '@angular/http'; 
//import 'rxjs/Rx';
import { Router, ActivatedRoute, Params } from '@angular/router';


@Component({
  selector: 'app-room',
  templateUrl: './room.component.html',
  styleUrls: ['./room.component.css']
})
export class RoomComponent implements OnInit {

  public isLogin: boolean;
  http: Http;
   router: Router;
    route: ActivatedRoute; 
    data: any[];

  constructor(route: ActivatedRoute, http: Http, router: Router) {
     this.http = http; 
     this.router = router; 
     this.route = route;
     }
  
  ngOnInit() {

   

    this.route.params.subscribe((params: Params) => { 
      let id = params['id']; 
      let headers = new Headers();
       headers.append('Content-Type', 'application/x-www-form-urlencoded'); 
       headers.append("token",localStorage.getItem("token"));
        this.http.get('http://localhost:8080/IT255-DZ14/getroom.php?id='+id,{headers:headers}).subscribe(data => {
           this.data =JSON.parse(data['_body']).room;
          },
           err => {
              this.router.navigate(['./']); 
          }
         ); 
        
        }); 
  }



}
