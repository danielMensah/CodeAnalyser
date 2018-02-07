import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';

import { AppComponent } from './app.component';
import { CodeFormComponent } from './code-form/code-form.component';
import { CodeResultsComponent } from './code-results/code-results.component';


@NgModule({
  declarations: [
    AppComponent,
    CodeFormComponent,
    CodeResultsComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
