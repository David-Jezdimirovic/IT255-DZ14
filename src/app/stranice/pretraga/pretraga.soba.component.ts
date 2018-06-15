import { Component, OnInit } from '@angular/core';
//import { Http, Response } from '@angular/http';
import { Http, Headers } from '@angular/http';
import { Router } from '@angular/router';
import { FormGroup, FormControl } from '@angular/forms';


@Component({
  selector: 'pretraga-component',
  templateUrl: './pretraga.soba.component.html',
  styleUrls: ['../../../assets/scss/base.scss'],
  
})



export class PretragaSobaComponent{
  data: any[];
  message: String;
  check:boolean;
  private sobe:Array<any> = [];
  private kvadrati = 0;
  private kreveti = 0;
  
  public searchForm = new FormGroup({
    id: new FormControl(),
  });

  public deleteForm = new FormGroup({
    id: new FormControl(),
  });


  constructor(private _http: Http, private _router: Router) { }

 
  ngOnInit() {
    const headers = new Headers();
    headers.append('Content-Type', 'application/x-www-form-urlencoded');
    headers.append('token', localStorage.getItem('token'));
    this._http.get('http://localhost:8080/IT255-DZ14/getrooms.php', {headers: headers})
      .subscribe(data => {
          this.sobe = JSON.parse(data['_body']).rooms;
         
        },
        err => {
          this._router.navigate(['']);
        }
      );
  }


  public removeRoom(event: Event, item: Number) { 
    var headers = new Headers(); 
    headers.append('Content-Type', 'application/x-www-form-urlencoded');
    headers.append('token', localStorage.getItem('token'));
     this._http.get('http://localhost:8080/IT255-DZ14/deleteroom.php?id='+item, {headers:headers})  .subscribe( data => {
        event.srcElement.parentElement.parentElement.remove();
        //data => this.postResponse = data;
      }); 
    }


    public viewRoom(item: Number){
       this._router.navigate(['../room', item]);
       }


    public updateRoom(item: Number){

      this._router.navigate(['../updateroom',item]);
        
      }



      public searchRoom(){
        var id = this.searchForm.value.id; 
        var headers = new Headers(); 
        headers.append('Content-Type', 'application/x-www-form-urlencoded');
        headers.append('token', localStorage.getItem('token'));
         this._http.get('http://localhost:8080/IT255-DZ14/getroombyid.php?id='+id, {headers:headers})  .subscribe( data => {
         
          this.data =JSON.parse(data['_body']).room;
        
           if(this.data['id'] != null){
             this.check = true;
           }else{
            this.check = false;
            this.message="Trazena soba ne postoji";
            
        
            }
        }, err => {
          alert("neuspeh");
        });
      }






      public deleteRoom(){
        var id = this.deleteForm.value.id; 
        var headers = new Headers(); 
        headers.append('Content-Type', 'application/x-www-form-urlencoded');
        headers.append('token', localStorage.getItem('token'));
         this._http.get('http://localhost:8080/IT255-DZ14/deleteroom.php?id='+id, {headers:headers})  .subscribe( data => {
        
        }, err => {
          alert("neuspeh");
        });
      }





}