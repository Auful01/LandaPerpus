import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DaftarBukuComponent } from './book/daftar-buku/daftar-buku.component';
import { DaftarCustomerComponent } from './customers/components/daftar-customer/daftar-customer.component';
import { DaftarItemComponent } from './items/components/daftar-item/daftar-item.component';
import { DaftarRolesComponent } from './roles/components/daftar-roles/daftar-roles.component';
import { DaftarTransactionComponent } from './transaction/daftar-transaction/daftar-transaction.component';
import { DaftarTransaksikuComponent } from './transaction/daftar-transaksiku/daftar-transaksiku.component';
import { DaftarUserComponent } from './users/components/daftar-user/daftar-user.component';

const routes: Routes = [
    { path: 'users', component: DaftarUserComponent },
    { path: 'roles', component: DaftarRolesComponent },
    { path: 'customers', component: DaftarCustomerComponent },
    { path: 'items', component: DaftarItemComponent },
    { path: 'book', component: DaftarBukuComponent },
    { path: 'transaction', component: DaftarTransactionComponent },
    { path: 'transaksiku', component: DaftarTransaksikuComponent },
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class MasterRoutingModule { }
